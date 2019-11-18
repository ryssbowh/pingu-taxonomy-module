<?php

namespace Pingu\Taxonomy\Entities\Uris;

use Pingu\Entity\Support\BaseEntityUris;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemUris extends BaseEntityUris
{   
    protected function uris(): array
    {
        return [
            'create' => Taxonomy::routeSlug().'/{'.Taxonomy::routeSlug().'}/items/create',
            'store' => Taxonomy::routeSlug().'/{'.Taxonomy::routeSlug().'}/items',
            'patch' => Taxonomy::routeSlug().'/{'.Taxonomy::routeSlug().'}/items',
        ];
    }
}