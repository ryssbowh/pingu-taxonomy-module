<?php

namespace Pingu\Taxonomy\Entities\Validators;

use Pingu\Field\Support\FieldValidator\BaseFieldsValidator;

class FieldTaxonomyValidator extends BaseFieldsValidator
{
    /**
     * @inheritDoc
     */
    protected function rules(): array
    {
        return [
            'taxonomy' => 'required|exists:taxonomies,id',
            'name' => 'required|string',
            'required' => 'sometimes',
            'multiple' => 'sometimes'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function messages(): array
    {
        return [];
    }
}