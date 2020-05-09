<?php

namespace Pingu\Taxonomy\Entities\Uris;

use Pingu\Core\Support\Uris\BaseModelUris;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemUris extends BaseModelUris
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