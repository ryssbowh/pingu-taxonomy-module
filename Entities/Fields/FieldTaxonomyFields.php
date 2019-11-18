<?php

namespace Pingu\Taxonomy\Entities\Fields;

use Pingu\Field\BaseFields\Boolean;
use Pingu\Field\BaseFields\Model;
use Pingu\Field\Support\FieldRepository\BundleFieldFieldRepository;
use Pingu\Taxonomy\Entities\Taxonomy;

class FieldTaxonomyFields extends BundleFieldFieldRepository
{
    /**
     * @inheritDoc
     */
    protected function fields(): array
    {
        return [
            new Boolean('required'),
            new Boolean('multiple'), 
            new Model(
                'taxonomy',
                [
                    'label' => 'Vocabulary',
                    'model' => Taxonomy::class,
                    'textField' => 'name',
                    'multiple' => false,
                    'allowNoValue' => false,
                    'required' => true
                ]
            ),
        ];
    }
}