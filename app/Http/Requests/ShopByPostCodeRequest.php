<?php

namespace App\Http\Requests;

use App\Rules\PostCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as HttpStatuses;

class ShopByPostCodeRequest extends FormRequest
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
        return [
            'post_code' => ['required', 'string', 'min:7', 'max:8', new PostCode],
            'distance'  => ['nullable', 'integer'], // could set a maximum distance in metres so queries are not silly, but initially api only returning the first 100 records ordered by distance 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Throws a validation exception with JSON response
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], HttpStatuses::HTTP_BAD_REQUEST)
        );
    }
}
