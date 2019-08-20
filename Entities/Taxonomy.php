<?php

namespace Pingu\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Relations\Relation;
use Pingu\Core\Contracts\Models\HasContextualLinksContract;
use Pingu\Core\Contracts\Models\HasItemsContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasBasicCrudUris;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Fields\Textarea;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Jsgrid\Contracts\Models\JsGridableContract;
use Pingu\Jsgrid\Fields\Text;
use Pingu\Jsgrid\Traits\Models\JsGridable;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class Taxonomy extends BaseModel implements JsGridableContract, HasItemsContract, HasContextualLinksContract
{
    use Formable, JsGridable, HasBasicCrudUris, HasMachineName;

    protected $visible = ['id', 'name', 'machineName', 'description'];

    protected $fillable = ['name', 'machineName', 'description'];

    protected $attributes = [
    	'description' => ''
    ];

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

    public function getContextualLinks(): array
    {
        return [
            'edit' => [
                'title' => 'Edit',
                'url' => $this::makeUri('edit', $this, adminPrefix())
            ],
            'items' => [
                'title' => 'Items',
                'url' => $this::makeUri('editItems', $this, adminPrefix())
            ]
        ];
    }

    /**
     * Uri for editing items
     *
     * @return string
     */
    public static function editItemsUri()
    {
        return static::routeSlug().'/{'.static::routeSlug().'}/items';
    }
}
