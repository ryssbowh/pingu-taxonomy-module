<?php

namespace Pingu\Taxonomy\Entities;

use Pingu\Field\Entities\BaseBundleField;
use Pingu\Forms\Support\Field;
use Pingu\Forms\Support\Fields\Select;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class FieldTaxonomy extends BaseBundleField
{
    protected $fillable = ['taxonomy', 'required', 'multiple'];

    protected $casts = [
        'required' => 'boolean',
        'multiple' => 'boolean'
    ];

    protected static $availableWidgets = [Select::class];

    /**
     * Taxonomy relation
     * 
     * @return BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    /**
     * @inheritDoc
     */
    public function defaultValue()
    {
        return $this->default;
    }

    /**
     * @inheritDoc
     */
    public function singleFormValue($value)
    {
        return array_map(
            function ($value) {
                return $value->getKey();
            }, $value
        );
    }

    /**
     * @inheritDoc
     */
    public function castSingleValue($value)
    {
        if ($value) {
            return TaxonomyItem::find($value);
        }
    }

    /**
     * @inheritDoc
     */
    public static function friendlyName(): string
    {
        return 'Taxonomy Terms';
    }
    
    /**
     * @inheritDoc
     */
    public function toSingleFormField($value): Field
    {
        return new Select(
            $this->machineName(),
            [
                'showLabel' => false,
                'model' => TaxonomyItem::class,
                'items' => $this->taxonomy->items->keyBy('id')->pluck('name')->all(),
                'textField' => 'name',
                'allowNoValue' => !$this->required,
                'multiple' => $this->multiple,
                'valueField' => 'id'
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function defaultValidationRule(): string
    {
        return 'bail|' . ($this->required ? 'required|' : '') . 'exists:taxonomy_items,id|taxonomy_vocabulary:'.$this->taxonomy_id;
    }

    /**
     * @inheritDoc
     */
    public function fixedCardinality()
    {
        return 1;
    }
}
