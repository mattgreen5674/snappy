<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ShopByPostCodeRequest;
use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\PostCode;
use App\Models\Shop;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as HttpStatuses;

class ShopController extends Controller
{
    public function create (ShopRequest $request): JsonResource|JsonResponse
    {
        try {
            $shop         = Shop::create($request->all()); // Shop name must be unique, so cannot already exist in DB
            $shopResource = new ShopResource($shop);

            return $shopResource->response()->setStatusCode(HttpStatuses::HTTP_CREATED);

        } catch (Exception $e) {
            info($e);
            // Log error with monitoring system
            return response()->json(['message' => 'The new record could not be created'], HttpStatuses::HTTP_BAD_REQUEST);
        }
    }

    public function nearToPostCode (ShopByPostCodeRequest $request): JsonResource|JsonResponse
    {
        $postCode = PostCode::where('post_code', Str::upper($request->post_code))->first();

        if (! $postCode) {
            return response()->json(['message' => 'Post code not found'], HttpStatuses::HTTP_NOT_FOUND);
        }

        try {
            $maxDistance = $request->distance ?? config('snappy.app.default.model.shop.distance.default_max');
            $distanceArr = [
                (config('snappy.app.default.model.shop.distance.radius_of_earth_in_miles') *  config('snappy.app.default.model.shop.distance.metres_per_mile')), // radius of earth in metres
                $postCode->latitude,
                $postCode->longitude,
                $postCode->latitude,
            ];
            $distanceAlgorithm = '(? * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))'; // haversine algorythm

            $shops = Shop::selectRaw('shops.*, ' . $distanceAlgorithm . ' as distance_from', $distanceArr)
                ->whereRaw($distanceAlgorithm . ' <= ' . $maxDistance, $distanceArr)
                ->orderBy('distance_from')
                ->limit(100) // limited for testing
                ->get();

            return ShopResource::collection($shops);

        } catch (Exception $e) {
            info($e);
            // Log error with monitoring system
            return ShopResource::collection(collect());
        }
    }

    public function willDeliverToPostCode (ShopByPostCodeRequest $request): JsonResource|JsonResponse
    {
        $request->merge(['distance' => 'max_delivery_distance']);
        return $this->nearToPostCode($request);
    }
}
