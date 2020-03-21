<?php

namespace Pingu\Taxonomy\Entities\Validators;

use Pingu\Field\Support\FieldValidator\BaseFieldsValidator;

class TaxonomyItemValidator extends BaseFieldsValidator
{
    /**
     * @inheritDoc
     */
    protected function rules(bool $updating): array
    {
        return [
            'name' => 'required',
            'taxonomy' => 'required|exists:taxonomies,id',
            'parent' => 'sometimes|exists:taxonomy_items,id',
            'weight' => 'nullable|integer',
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
            'machineName.required' => 'Machine Name is required',
            'machineName.unique' => 'Machine name already exists'
        ];
    }
}