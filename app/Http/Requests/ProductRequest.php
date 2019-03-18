<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'name' => 'required|string',
			'unit_price' => 'required|numeric',
			'file' => 'required|max:10000|mimes:jpg,png,jpeg',
            'description' => 'nullable|string|max:255'
		];

		if ($this->_method == 'PUT') {
			$rules['file'] = 'nullable|max:10000|mimes:jpg,png,jpeg';
		}

		return $rules;
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
