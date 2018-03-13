<?php

namespace MinhD\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecord extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('record')) {
            $owner = $this->route('record')->datasource->owner;
            return !! $this->user() && $this->user()->id === $owner->id;
        }

        return !! $this->user();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() === "PUT") {
            return [
                'data_source_id' => 'exists:data_sources,id'
            ];
        }

        return [
            'version' => 'required',
            'version.status' => 'required',
            'version.data' => 'required',
            'data_source_id' => 'exists:data_sources,id'
        ];
    }
}
