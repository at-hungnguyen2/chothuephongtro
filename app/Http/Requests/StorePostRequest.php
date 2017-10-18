<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Post;

class StorePostRequest extends FormRequest
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
            'post_type_id' => 'required|integer',
            'cost_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'district_id' => 'required|integer',
            'street_id' => 'required|integer',
            'title' => 'required',
            'content' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required'
        ];
    }
}
