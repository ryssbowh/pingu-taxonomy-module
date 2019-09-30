<?php

namespace Pingu\Taxonomy\Entities;

use Pingu\Content\Traits\ContentField;
use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Traits\BundleField;
use Pingu\Forms\Support\Fields\Checkbox;
use Pingu\Forms\Support\Fields\ModelCheckboxes;
use Pingu\Forms\Support\Fields\ModelSelect;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Types\ManyModel;
use Pingu\Forms\Traits\Models\Formable;

class FieldTaxonomy extends BaseModel implements BundleFieldContract
{
	use BundleField, Formable;

    protected $fillable = ['name', 'taxonomy', 'required', 'multiple'];

    protected $casts = [
        'required' => 'boolean',
        'multiple' => 'boolean'
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
        return ['name', 'taxonomy', 'required', 'multiple'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'taxonomy', 'required', 'multiple'];
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
            'name' => [
                'field' => TextInput::class,
                'attributes' => [
                    'required' => true
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
            'name' => 'required|string',
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
    public static function friendlyName(): string
    {
    	return 'Taxonomy Terms';
    }
    
    /**
     * @inheritDoc
     */
    public function bundleFieldDefinition()
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
    public function bundleFieldValidationRule()
    {
        return ($this->required ? 'required|' : '') . 'exists:taxonomy_items,id';
    }

    /**
     * @inheritDoc
     */
    public function bundleFieldValidationMessages()
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
