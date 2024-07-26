<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => 'required|string|max:1000',
            'answer' => 'required|array|min:4',
            'answer.*' => 'required|string|max:255',
            'correct' => 'required|array|min:1',
            'point' => 'required|numeric|gt:0',
            'time_total' => 'required|integer|max:200',
            'time_limit' => 'required|integer',
            'point_percent' => 'required|integer',
            'minimal_point' => 'required|numeric',
        ];
    }

    /**
     * Get the custom error messages for the validator.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'point.numeric' => 'The point must be a number.',
            'point.gt' => 'The point must be greater than zero.',
            'time_total.integer' => 'The total time must be an integer.',
            'time_total.max' => 'The total time cannot be more than 200 minutes.',
            'point_percent.integer' => 'The point percent must be an integer.',
            'minimal_point.numeric' => 'The minimal point must be a number.',
        ];
    }
}
