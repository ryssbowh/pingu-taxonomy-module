<?php

namespace Pingu\Taxonomy\Entities;

use Pingu\Content\Contracts\ContentFieldContract;
use Pingu\Content\Traits\ContentField;
use Pingu\Core\Entities\BaseModel;
use Pingu\Forms\Support\Fields\Checkbox;
use Pingu\Forms\Support\Fields\ModelCheckboxes;
use Pingu\Forms\Support\Fields\ModelSelect;
use Pingu\Forms\Support\Types\ManyModel;
use Pingu\Forms\Traits\Models\Formable;

class FieldTaxonomy extends BaseModel implements ContentFieldContract
{
	use ContentField, Formable;

    protected $fillable = ['taxonomy', 'required', 'multiple'];

    protected $casts = [
        'required' => false,
        'multiple' => false
    ];

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['taxonomy', 'required', 'multiple'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['taxonomy', 'required', 'multiple'];
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
    {
        return [
            'taxonomy' => [
                'field' => ModelSelect::class,
                'options' => [
                    'label' => 'Vocabulary',
                    'model' => Taxonomy::class,
                    'textField' => 'name',
                    'multiple' => false,
                    'allowNoValue' => false
                ]
            ],
            'required' => [
                'field' => Checkbox::class
            ],
            'multiple' => [
                'field' => Checkbox::class
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationRules()
    {
        return [
            'taxonomy' => 'required|exists:taxonomies,id',
            'required' => 'sometimes',
            'multiple' => 'sometimes'
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function friendlyName()
    {
    	return 'Taxonomy Terms';
    }
    
    /**
     * @inheritDoc
     */
    public function fieldDefinition()
    {
        return [
            'field' => ModelSelect::class,
            'options' => [
                'model' => TaxonomyItem::class,
                'items' => $this->taxonomy->items,
                'textField' => 'name',
                'allowNoValue' => !$this->required
            ],
            'attributes' => [
                'multiple' => $this->multiple
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function fieldValidationRules()
    {
        return ($this->required ? 'required|' : '') . 'exists:taxonomy_items,id';
    }

    /**
     * @inheritDoc
     */
    public function fieldValidationMessages()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function getMachineName()
    {
        return 'taxonomy';
    }
}
