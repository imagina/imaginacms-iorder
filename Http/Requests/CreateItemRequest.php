<?php

namespace Modules\Iorder\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateItemRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'order_id' => 'required',
          'entity_type' => 'required',
          'entity_id' => 'required',
        ];
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
