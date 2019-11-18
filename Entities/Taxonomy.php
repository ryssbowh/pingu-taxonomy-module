<?php

namespace Pingu\Taxonomy\Entities;

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
