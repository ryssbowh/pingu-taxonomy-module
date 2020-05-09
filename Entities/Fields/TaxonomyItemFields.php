<?php

namespace Pingu\Taxonomy\Entities\Fields;

use Pingu\Field\BaseFields\Integer;
use Pingu\Field\BaseFields\Model;
use Pingu\Field\BaseFields\Text;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyItemFields extends BaseFieldRepository
{
    /**
     * @inheritDoc
     */
    protected function fields(): array
    {
        return [
            new Text('name'),
            new Text('description'),
            new Integer('weight'),
            new Model(
                'taxonomy',
                [
                    'model' => Taxonomy::class,
                    'textField' => 'name',
                    'default' => $this->object->taxonomy,
                    'allowNoValue' => false,
                ]
            ),
            new Model(
                'parent',
                [
                    'model' => TaxonomyItem::class,
                    'textField' => 'name',
                    'default' => $this->object->parent
                ]
            )
        ];
    }

    /**
     * @inheritDoc
     */
    protected function rules(): array
    {
        return [
            'name' => 'required',
            'taxonomy' => 'required|exists:taxonomies,id',
            'parent' => 'nullable|exists:taxonomy_items,id',
            'weight' => 'nullable|integer',
            'description' => 'nullable|string'
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