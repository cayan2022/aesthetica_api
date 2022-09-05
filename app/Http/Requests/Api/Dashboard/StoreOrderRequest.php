<?php

namespace App\Http\Requests\Api\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'source_id' => 'required|integer|exists:sources,id',
            'category_id' => 'required|integer|exists:categories,id',
            'status_id' => 'required|integer|exists:statuses,id',
            'branch_id' => 'required|integer|exists:branches,id',
        ];
    }
}
