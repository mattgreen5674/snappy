<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ShopByPostCodeRequest;
use App\Http\Resources\ShopResource;
use App\Models\PostCode;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function nearToPostCode (ShopByPostCodeRequest $request)
    {
        $postCode = PostCode::where('post_code', Str::upper($request->post_code))->first();
        if (! $postCode) {
            return [];
        }

        $distance    = $request->distance ?? config('snappy.app.default.model.shop.distance.default_max');
        $distanceArr = [
            (config('snappy.app.default.model.shop.distance.radius_of_earth_in_miles') *  config('snappy.app.default.model.shop.distance.metres_per_mile')), // radius of earth in metres
            $postCode->latitude,
            $postCode->longitude,
            $postCode->latitude,
        ];
        $distanceAlgorythm = '(? * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))'; // haversine algorythm

        $shops = Shop::selectRaw('shops.*, ' . $distanceAlgorythm . ' as distance_from', $distanceArr)
            ->whereRaw($distanceAlgorythm . ' <= ' . $distance, $distanceArr)
            ->orderBy('distance')
            ->limit(100) // limited for testing
            ->get();

        return ShopResource::collection($shops);
    }

    public function willDeliverToPostCode (ShopByPostCodeRequest $request)
    {
        $request->merge(['distance' => 'max_delivery_distance']);
        return $this->nearToPostCode($request);
    }
}
