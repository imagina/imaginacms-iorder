<?php

namespace Modules\Iorder\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateOrderRequest extends BaseFormRequest
{
    public function rules()
    {
        return ['customer_id' => 'required',];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
    
}
