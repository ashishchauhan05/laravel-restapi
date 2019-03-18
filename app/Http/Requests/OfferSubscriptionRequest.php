<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferSubscriptionRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'offer_id' => 'required|numeric',
            'name' => 'required|string|max:10',
            'email' => 'nullable|string|max:100',
            'mobile' => 'required|string|max:20',
            'description' => 'nullable|string|max:100'
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
}
