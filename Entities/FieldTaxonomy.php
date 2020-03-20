<?php

namespace Pingu\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Builder;
use Pingu\Entity\Entities\Entity;
use Pingu\Field\Entities\BaseBundleField;
use Pingu\Forms\Support\Field;
use Pingu\Forms\Support\Fields\Checkboxes;
use Pingu\Forms\Support\Fields\Select;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class FieldTaxonomy extends BaseBundleField
{
    protected $fillable = ['taxonomy', 'required'];

    protected $casts = [
        'required' => 'boolean'
    ];

    protected static $availableWidgets = [Select::class, Checkboxes::class];

    protected static $availableFilterWidgets = [Select::class, Checkboxes::class];

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
    public function castSingleValueToDb($value)
    {
        if (is_null($value)) {
            return null;
        }
        return $value->getKey();
    }

    /**
     * @inheritDoc
     */
    public function castToSingleFormValue($value)
    {
        return $value ? $value->getKey() : '';
    }

    /**
     * @inheritDoc
     */
    public function castSingleValueFromDb($value)
    {
        return $value ? (int)$value : null;
    }

    /**
     * @inheritDoc
     */
    public function castSingleValue($value)
    {
        return $value ? TaxonomyItem::find($value) : null;
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
    public function formFieldOptions(int $index = 0): array
    {
        $items = $this->taxonomy->getItems()->pluck('name', 'id')->all();
        $items = ['' => $this->taxonomy->name] + $items;
        return [
            'items' => $items,
            'required' => $this->required,
            'multiple' => false,
            'data-placeholder' => 'Select '.$this->taxonomy->name
        ];
    }

    /**
     * @inheritDoc
     */
    public function defaultValidationRule(): string
    {
        return 'exists:taxonomy_items,id|taxonomy_vocabulary:'.$this->taxonomy_id;
    }

    /**
     * @inheritDoc
     */
    public function singleFilterQueryModifier(Builder $query, $value, Entity $entity)
    {
        $query->where('value', '=', $value);
    }
}
