<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HttpStatuses;

class ShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // If they get through the api middleware, then they should be authorised.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $statuses = array_values(config('snappy.app.default.model.shop.status'));
        $types    = array_values(config('snappy.app.default.model.shop.type'));

        return [
            'name'                  => ['required', 'string', 'min:3', 'max:255', Rule::unique('shops', 'name')],
            'latitude'              => ['required', 'numeric', 'between:-90,90'],
            'longitude'             => ['required', 'numeric', 'between:-180,180'],
            'status'                => ['required', 'string', Rule::in($statuses)],
            'type'                  => ['required', 'string', Rule::in($types)],
            'max_delivery_distance' => ['required', 'integer', 'min:500', 'max:16094'], // in metres max = 10 miles (can be adjusted with more input)
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Throws a validation exception with JSON response
        throw new HttpResponseException(
            response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], HttpStatuses::HTTP_BAD_REQUEST)
        );
    }
}
