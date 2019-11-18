<?php

namespace Pingu\Taxonomy\Entities\Routes;

use Pingu\Entity\Support\BaseEntityRoutes;

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

    /**
     * @inheritDoc
     */
    protected function methods(): array
    {
        return [
            'editItems' => 'get'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function names(): array
    {
        return [
            'admin.index' => 'taxonomy.admin.taxonomy',
            'admin.create' => 'taxonomy.admin.create'
        ];
    }
}