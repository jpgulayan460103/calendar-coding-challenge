<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Rules\CustomDateValidation;

class EventStoreRequest extends FormRequest
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
            'name' => 'required',
            'start_date' => ['required', new CustomDateValidation],
            'end_date' => ['required', new CustomDateValidation],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateDateRange($validator);
        });
    }

    private function validateDateRange($validator)
    {
        $start_date = Carbon::parse($this->input('start_date'));
        $end_date = Carbon::parse($this->input('end_date'));
        if($start_date->diffInDays($end_date, false) < 0){
            $validator->errors()->add("start_date", "Invalid Date Range");
            $validator->errors()->add("end_date", "Invalid Date Range");
        }
    }

}
