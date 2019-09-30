<?php

namespace Pingu\Taxonomy\Entities\Uris;

use Pingu\Entity\Support\BaseEntityUris;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemUris extends BaseEntityUris
{	
    public function create(): string
    {
        return Taxonomy::routeSlug().'/{'.Taxonomy::routeSlug().'}/create';
    }

    public function store(): string
    {
        return Taxonomy::routeSlug().'/{'.Taxonomy::routeSlug().'}/items';
    }

    public function delete(): string
    {
        return $this->update().'/delete';
    }

    public function edit(): string
    {
        return $this->update().'/edit';
    }

    public function update(): string
    {
        return $this->object::routeSlug().'/{'.$this->object::routeSlug().'}';
    }

    public function patch(): string
    {
        return $this->object::routeSlugs();
    }
}