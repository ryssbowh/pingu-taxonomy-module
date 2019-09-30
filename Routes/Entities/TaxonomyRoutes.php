<?php

namespace Pingu\Taxonomy\Routes\Entities;

use Pingu\Entity\Support\BaseEntityRoutes;

class TaxonomyRoutes extends BaseEntityRoutes
{
    protected function routes(): array
    {
        return [
            'admin' => [
                'index', 'create', 'store', 'edit', 'update', 'confirmDelete', 'delete', 'editItems', 'patchItems'
            ],
            'ajax' => [
                'index', 'create', 'store', 'edit', 'update', 'delete', 'patchItems'
            ]
        ];
    }

    protected function routeMiddlewares(): array
    {
        return [
            'index' => 'can:view taxonomy vocabularies',
            'create' => 'can:add taxonomy vocabularies',
            'store' => 'can:add taxonomy vocabularies',
            'edit' => 'can:edit taxonomy vocabularies',
            'update' => 'can:edit taxonomy vocabularies',
            'confirmDelete' => 'can:delete taxonomy vocabularies',
            'delete' => 'can:delete taxonomy vocabularies',
            'editItems' => 'can:view taxonomy terms',
            'patchItems' => 'can:edit taxonomy terms',
        ];
    }

    protected function routeMethods(): array
    {
        return array_merge(parent::routeMethods(), [
            'editItems' => 'get',
            'patchItems' => 'patch'
        ]);
    }

    protected function routeNames(): array
    {
        return [
            'admin.index' => 'taxonomy.admin.taxonomy',
            'admin.create' => 'taxonomy.admin.create'
        ];
    }
}