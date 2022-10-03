<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreSourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RuleFactory::make([
                                     '%name%' => ['required', 'string'],
                                     '%short_description%' => ['required', 'string'],
                                     'identifier' => ['required','regex:/^[a-zA-Z0-9]*$/','max:255'],
                                     'image' => ['nullable', new SupportedImage()]
                                 ]);
    }
}
