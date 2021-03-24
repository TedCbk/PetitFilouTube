<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ChannelUpdateRequest extends FormRequest
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
        // Add current id to exclude it from the rules, so the you can update even if you don't change anything
        $channelId = Auth::user()->channel->first()->id;
        
        return [
            'name' => 'required|max:255|unique:channels,name,' . $channelId,
            'slug' => 'required|max:255|alpha_num|unique:channels,slug,' . $channelId,
            'description' => ['max:1000']
        ];
    }
}
