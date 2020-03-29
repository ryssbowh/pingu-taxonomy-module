<?php

namespace Pingu\Taxonomy\Entities\Actions;

use Pingu\Entity\Support\Actions\BaseEntityActions;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyActions extends BaseEntityActions
{
    /**
     * @inheritDoc
     */
    public function actions(): array
    {
        return [
            'edit' => [
                'label' => 'Edit',
                'url' => function ($entity) {
                    return $entity->uris()->make('edit', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('edit', $entity);
                }
            ],
            'editItems' => [
                'label' => 'Items',
                'url' => function ($entity) {
                    return $entity->uris()->make('editItems', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('edit-items', $entity);
                }
            ],
            'delete' => [
                'label' => 'Delete',
                'url' => function ($entity) {
                    return $entity->uris()->make('confirmDelete', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('delete', $entity);
                }
            ],
        ];
    }
}