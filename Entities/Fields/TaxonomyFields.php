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
}