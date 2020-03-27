<?php

namespace Pingu\Taxonomy\Entities\Routes;

use Pingu\Entity\Support\Routes\BaseEntityRoutes;

class TaxonomyRoutes extends BaseEntityRoutes
{
    /**
     * @inheritDoc
     */
    protected function routes(): array
    {
        return [
            'admin' => [
                'editItems'
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function middlewares(): array
    {
        return [
            'editItems' => 'can:edit-items,taxonomy'
        ];
    }
}