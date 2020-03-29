<?php

namespace Pingu\Taxonomy\Entities\Uris;

use Pingu\Entity\Support\Uris\BaseEntityUris;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyUris extends BaseEntityUris
{
    protected function uris(): array
    {
        return [
            'editItems' => Taxonomy::routeSlug().'/{'.Taxonomy::routeSlug().'}/items'
        ];
    }
}