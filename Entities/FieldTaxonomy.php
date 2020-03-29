<?php

namespace Pingu\Taxonomy\Entities;

use Pingu\Field\Entities\BaseBundleField;
use Pingu\Field\Traits\HandlesModel;
use Pingu\Forms\Support\Fields\Checkboxes;
use Pingu\Forms\Support\Fields\Select;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class FieldTaxonomy extends BaseBundleField
{
    use HandlesModel;

    protected $fillable = ['taxonomy', 'required'];

    protected $casts = [
        'required' => 'boolean'
    ];

    protected static $availableWidgets = [Select::class, Checkboxes::class];

    protected static $availableFilterWidgets = [Select::class, Checkboxes::class];

    /**
     * @inheritDoc
     */
    protected function getModel(): string
    {
        return TaxonomyItem::class;
    }

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
}
