<?php

namespace Pingu\Taxonomy\Entities\Fields;

use Pingu\Field\BaseFields\LongText;
use Pingu\Field\BaseFields\Text;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;

class TaxonomyFields extends BaseFieldRepository
{
    /**
     * @inheritDoc
     */
    protected function fields(): array
    {
        return [
            new Text(
                'name',
                [
                    'required' => true
                ]
            ),
            new Text(
                'machineName',
                [
                    'label' => 'Machine name',
                    'required' => true,
                    'dashifyFrom' => 'name'
                ]
            ),
            new LongText('description')
        ];
    }

    /**
     * @inheritDoc
     */
    protected function rules(): array
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