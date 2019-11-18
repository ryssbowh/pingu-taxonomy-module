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
}