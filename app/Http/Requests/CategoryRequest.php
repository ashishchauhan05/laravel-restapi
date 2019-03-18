<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = array(
			'name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string|max:255'
		);

		if ($this->getMethod == 'PUT') {
			$rules['name'] = 'required|string|max:100';
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
