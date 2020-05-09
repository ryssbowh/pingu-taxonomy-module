<?php

namespace Pingu\Taxonomy\Entities\Uris;

use Pingu\Core\Support\Uris\BaseModelUris;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyUris extends BaseModelUris
{
    protected function uris(): array
    {
        return [
            'editItems' => '@slug@/{@slug@}/items'
        ];
    }
}