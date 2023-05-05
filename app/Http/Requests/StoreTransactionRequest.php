<?php

namespace App\Http\Requests;

use App\Enums\ServiceEnum;
use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'uuid', 'exists:customers,id'],
            'description' => ['required', 'string', new Enum(ServiceEnum::class)],
            'status'      => ['required', new Enum(StatusEnum::class)],
            'amount'      => ['required', 'integer', 'min:0']
        ];
    }
}
