<?php

namespace Pingu\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Pingu\Core\Contracts\HasItemsContract;
use Pingu\Core\Support\Actions;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Entity\Support\Entity;
use Pingu\Taxonomy\Entities\TaxonomyItem;
use Pingu\Taxonomy\Http\Contexts\EditTaxonomyContext;
use Pingu\Taxonomy\Http\Contexts\UpdateTaxonomyContext;

class Taxonomy extends Entity implements HasItemsContract
{
    use HasMachineName;

    protected $visible = ['id', 'name', 'machineName', 'description'];

    protected $fillable = ['name', 'machineName', 'description'];

    protected $attributes = [
        'description' => ''
    ];

    public $adminListFields = ['name', 'description'];

    public $descriptiveField = 'name';

    public static $routeContexts = [UpdateTaxonomyContext::class, EditTaxonomyContext::class];

    protected $itemsInstance;

    /**
     * @inheritDoc
     */
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
     * Items getter
     * 
     * @return Collection
     */
    public function getItems(): Collection
    {
        if (is_null($this->itemsInstance)) {
            $this->itemsInstance = $this->items;
        }
        return $this->itemsInstance;
    }

    /**
     * Get the direct children of this taxonomy
     * 
     * @return Collection
     */
    public function getRootItems($orderBy = 'weight')
    {
        return $this->getItems()
            ->where('parent_id', null)
            ->sortBy($orderBy);
    }

    /**
     * Returns the next weight
     * 
     * @return integer
     */
    public function getRootNextWeight()
    {
        return $this->getRootItems()->isEmpty() ? 0 : $this->getRootItems()->last()->weight + 1;
    }
}
