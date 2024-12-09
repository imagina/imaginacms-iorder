<?php

namespace Modules\Iorder\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateSupplyRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'item_id' => 'required',
          'supplier_id' => 'required'
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
