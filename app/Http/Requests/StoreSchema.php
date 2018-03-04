<?php

namespace MinhD\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchema extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case "POST":
                return [
                    'title' => 'required',
                    'description' => '',
                    'url' => 'required|url',
                    'shortcode' => 'required'
                ];
                break;
            case "PUT":
                return [
                    'title' => '',
                    'description' => '',
                    'url' => 'url',
                    'shortcode' => ''
                ];
                break;
        }
    }
}
