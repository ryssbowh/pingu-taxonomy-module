<?php

namespace Pingu\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Relations\Relation;
use Pingu\Core\Contracts\Models\HasItemsContract;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Entity\Contracts\Actions;
use Pingu\Entity\Contracts\Routes;
use Pingu\Entity\Contracts\Uris;
use Pingu\Entity\Entities\BaseEntity;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Fields\Textarea;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Jsgrid\Fields\Text;
use Pingu\Taxonomy\Entities\Actions\TaxonomyActions;
use Pingu\Taxonomy\Entities\TaxonomyItem;
use Pingu\Taxonomy\Entities\Uris\TaxonomyUris;
use Pingu\Taxonomy\Routes\Entities\TaxonomyRoutes;

class Taxonomy extends BaseEntity implements HasItemsContract
{
    use Formable, HasMachineName;

    protected $visible = ['id', 'name', 'machineName', 'description'];

    protected $fillable = ['name', 'machineName', 'description'];

    protected $attributes = [
    	'description' => ''
    ];

    public $adminListFields = ['name', 'description'];

    public function routes(): Routes
    {
        return new TaxonomyRoutes($this);
    }

    public function actions(): Actions
    {
        return new TaxonomyActions($this);
    }

    public function uris(): Uris
    {
        return new TaxonomyUris($this);
    }

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'machineName', 'description'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'description'];
    }

    public function getRouteKeyName()
    {
        return 'machineName';
    }

    /**
     * A taxonomy can have several items
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): Relation
    {
        return $this->hasMany(TaxonomyItem::class)->orderBy('weight');
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
    {
        return [
            'name' => [
                'field' => TextInput::class,
                'attributes' => [
                    'required' => true
                ]
            ],
            'machineName' => [
                'field' => TextInput::class,
                'attributes' => [
                    'class' => 'js-dashify',
                    'data-dashifyfrom' => 'name',
                    'required' => true
                ]
            ],
            'description' => [
                'field' => Textarea::class
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationRules()
    {
        return [
            'name' => 'required',
            'machineName' => 'required|unique:taxonomies,machineName',
            'description' => 'string'
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [
            'name.required' => 'Name is required',
            'machineName.required' => 'Machine Name is required',
            'machineName.unique' => 'Machine name already exists'
        ];
    }

    public function jsGridFields()
    {
    	return [
    		'name' => [
    			'type' => Text::class
    		],
    		'description' => [
    			'type' => Text::class
    		]
    	];
    }

    /**
     * Get the direct children of this taxonomy
     * 
     * @return Collection
     */
    public function getRootItems()
    {
        return $this->items()
            ->where('parent_id', null)
            ->orderBy('weight', 'ASC')
            ->get();
    }

    /**
     * Returns the next weight
     * 
     * @return integer
     */
    public function getRootNextWeight()
    {
        return $this->items->isEmpty() ? 0 : $this->items->last()->weight + 1;
    }
}
