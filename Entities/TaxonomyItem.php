<?php

namespace Pingu\Taxonomy\Entities;

use Illuminate\Support\Str;
use Pingu\Core\Contracts\Models\HasChildrenContract;
use Pingu\Core\Traits\Models\HasChildren;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Entity\Contracts\Routes;
use Pingu\Entity\Contracts\Uris;
use Pingu\Entity\Support\Entity;
use Pingu\Taxonomy\Entities\Policies\TaxonomyItemPolicy;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\Uris\TaxonomyItemUris;
use Pingu\Taxonomy\Routes\Entities\TaxonomyItemRoutes;

class TaxonomyItem extends Entity implements HasChildrenContract
{
    use HasChildren, HasMachineName;

    protected $visible = ['id', 'weight', 'name', 'taxonomy', 'description'];

    protected $fillable = ['weight', 'name', 'taxonomy', 'description'];

    protected $attributes = [
        'description' => ''
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($item) {
                $item->generateMachineName();
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function getPolicy(): string
    {
        return TaxonomyItemPolicy::class;
    }

    /**
     * taxonomy relation
     * 
     * @return BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
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
        if($parent) {
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
     * @param  array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if(is_null($this->weight)) {
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
        if ($parent) {
            $item->parent()->associate($parent);
        }
        $item->save();
        return $item;
    }
}
