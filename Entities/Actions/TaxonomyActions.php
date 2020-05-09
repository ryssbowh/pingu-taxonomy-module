<?php

namespace Pingu\Taxonomy\Entities\Actions;

use Pingu\Core\Support\Actions\BaseAction;
use Pingu\Entity\Support\Actions\BaseEntityActions;

class TaxonomyActions extends BaseEntityActions
{
    /**
     * @inheritDoc
     */
    public function actions(): array
    {
        return [
            'editItems' => new BaseAction(
                'Items',
                function ($entity) {
                    return $entity->uris()->make('editItems', $entity, adminPrefix());
                },
                function ($entity) {
                    return \Gate::check('edit-items', $entity);
                },
                'admin'
            )
        ];
    }
}