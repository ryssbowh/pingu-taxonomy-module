<?php

namespace Pingu\Taxonomy\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Field\Traits\BundleField;
use Pingu\Forms\Support\Field;
use Pingu\Forms\Support\Fields\ModelSelect;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class FieldTaxonomy extends BaseModel implements BundleFieldContract
{
    use BundleField;

    protected $fillable = ['taxonomy', 'required', 'multiple'];

    protected $casts = [
        'required' => 'boolean',
        'multiple' => 'boolean'
    ];

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
    public function toSingleFormField(): Field
    {
        return new ModelSelect(
            $this->machineName,
            [
                'model' => TaxonomyItem::class,
                'items' => $this->taxonomy->items,
                'textField' => 'name',
                'allowNoValue' => !$this->required
            ],
            [
                'multiple' => $this->multiple
            ]
        );
    }

    /**
     * @inheritDoc
     */
    protected function defaultValidationRule(): string
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
