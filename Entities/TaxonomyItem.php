<?php

namespace Pingu\Taxonomy\Entities;

use Illuminate\Support\Str;
use Pingu\Core\Contracts\Models\HasChildrenContract;
use Pingu\Core\Contracts\Models\HasCrudUrisContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasBasicCrudUris;
use Pingu\Core\Traits\Models\HasChildren;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Forms\Contracts\Models\FormableContract;
use Pingu\Forms\Support\Fields\ModelSelect;
use Pingu\Forms\Support\Fields\NumberInput;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItem extends BaseModel implements HasChildrenContract, FormableContract, HasCrudUrisContract
{
    use HasChildren, Formable, HasBasicCrudUris, HasMachineName;

    protected $visible = ['id', 'weight', 'name', 'taxonomy', 'description'];

    protected $fillable = ['weight', 'name', 'taxonomy', 'description'];

    protected $attributes = [
    	'description' => ''
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($item){
            $item->generateMachineName();
        });
    }

    public function taxonomy()
    {
    	return $this->belongsTo(Taxonomy::class);
    }

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'description'];
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
                'field' => TextInput::class
            ],
            'description' => [
                'field' => TextInput::class
            ],
            'weight' => [
                'field' => NumberInput::class
            ],
            'taxonomy' => [
                'field' => ModelSelect::class,
                'options' => [
                    'model' => Taxonomy::class,
                    'textField' => 'name',
                    'default' => $this->taxonomy,
                    'allowNoValue' => false,
                ]
            ],
            'parent' => [
                'field' => ModelSelect::class,
                'options' => [
                    'model' => TaxonomyItem::class,
                    'textField' => 'name',
                    'default' => $this->parent
                ]
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
            'taxonomy' => 'required|exists:taxonomies,id',
            'parent' => 'sometimes|exists:taxonomy_items,id',
            'weight' => 'nullable|integer',
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
            'taxonomy.required' => 'Taxonomy is required',
            'parent.exists' => 'Parent must be a taxonomy item',
            'taxonomy.exists' => 'Taxonomy must be a taxonomy',
        ];
    }  

    /**
     * Generate a machine name for this item
     * 
     * @return string
     */
    public function generateMachineName()
    {
        $name = Str::kebab($this->name);
        $parent = $this->parent;
        if($parent){
            $name = Str::kebab($parent->machineName).'.'.$name;
        }
        else{
            $name = $this->taxonomy->machineName.'.'.$name;
        }
        $this::unguard();
        $this->machineName = $this->getUniqueMachineName($name);
    }

    /**
     * Overrides save to add a default weight
     * 
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if(is_null($this->weight)){
            $this->weight = $this->taxonomy->getRootNextWeight();
        }
        return parent::save($options);
    }

    /**
     * @inheritDoc
     */
    public static function create(array $values, Taxonomy $menu, TaxonomyItem $parent = null)
    {
        $item = new static;
        $item->fill($values);
        $item->taxonomy()->associate($menu);
        if($parent){
            $item->parent()->associate($parent);
        }
        $item->save();
        return $item;
    }

    /**
     * @inheritDoc
     */
    public static function createUri()
    {
        return static::storeUri().'/create';
    }

    /**
     * @inheritDoc
     */
    public static function storeUri()
    {
        return Taxonomy::routeSlug().'/{'.Taxonomy::routeSlug().'}/'.static::routeSlugs();
    }

    /**
     * @inheritDoc
     */
    public static function deleteUri()
    {
        return static::updateUri().'/delete';
    }

    /**
     * @inheritDoc
     */
    public static function editUri()
    {
        return static::updateUri().'/edit';
    }

    /**
     * @inheritDoc
     */
    public static function updateUri()
    {
        return static::routeSlugs().'/{'.static::routeSlug().'}';
    }

    /**
     * @inheritDoc
     */
    public static function patchUri()
    {
        return static::routeSlugs();
    }
}
