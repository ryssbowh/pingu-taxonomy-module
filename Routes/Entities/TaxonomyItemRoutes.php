<?php

namespace Pingu\Taxonomy\Routes\Entities;

use Pingu\Entity\Support\BaseEntityRoutes;

class TaxonomyItemRoutes extends BaseEntityRoutes
{
    protected function routes(): array
    {
        return [
            'admin' => [
                'create', 'store', 'edit', 'update', 'confirmDelete', 'delete'
            ],
            'ajax' => [
                'create', 'store', 'edit', 'update', 'delete'
            ]
        ];
    }

    protected function routeMiddlewares(): array
    {
        return [
            'create' => 'can:add taxonomy terms',
            'store' => 'can:add taxonomy terms',
            'edit' => 'can:edit taxonomy terms',
            'update' => 'can:edit taxonomy terms',
            'confirmDelete' => 'can:delete taxonomy terms',
            'delete' => 'can:delete taxonomy terms',
        ];
    }
}