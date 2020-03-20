<?php

namespace Pingu\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Pingu\Core\Contracts\Models\HasItemsContract;
use Pingu\Core\Support\Actions;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Entity\Entities\Entity;
use Pingu\Taxonomy\Entities\Actions\TaxonomyActions;
use Pingu\Taxonomy\Entities\Policies\TaxonomyPolicy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class Taxonomy extends Entity implements HasItemsContract
{
    use HasMachineName;

    protected $visible = ['id', 'name', 'machineName', 'description'];

    protected $fillable = ['name', 'machineName', 'description'];

    protected $attributes = [
        'description' => ''
    ];

    public $adminListFields = ['name', 'description'];

    protected $itemsInstance;

    /**
     * @inheritDoc
     */
    protected function getActionsInstance(): Actions
    {
        return new TaxonomyActions($this);
    }

    /**
     * @inheritDoc
     */
    public function getRouteKeyName()
    {
        return 'machineName';
    }

    /**
     * @inheritDoc
     */
    public function getPolicy(): string
    {
        return TaxonomyPolicy::class;
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
