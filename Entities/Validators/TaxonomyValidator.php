<?php

namespace Pingu\Taxonomy\Entities\Validators;

use Pingu\Field\Support\FieldValidator\BaseFieldsValidator;

class TaxonomyValidator extends BaseFieldsValidator
{
    /**
     * @inheritDoc
     */
    protected function rules(bool $updating): array
    {
        return [
            'name' => 'required',
            'machineName' => 'required|unique:taxonomies,machineName',
            'description' => 'string'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'taxonomy.required' => 'Taxonomy is required',
            'parent.exists' => 'Parent must be a taxonomy item',
            'taxonomy.exists' => 'Taxonomy must be a taxonomy',
        ];
    }
}