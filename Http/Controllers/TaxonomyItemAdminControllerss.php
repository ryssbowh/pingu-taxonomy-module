<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Http\Controllers\AdminEntityController;
use Pingu\Entity\Support\Entity;
use Pingu\Field\Contracts\FieldContextContract;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemAdminControllerss extends AdminEntityController
{
    /**
     * @inheritDoc
     */
    protected function onStoreSuccess(Entity $entity)
    {
        return redirect(Taxonomy::uris()->make('editItems', $entity->taxonomy, adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function onUpdateSuccess(Entity $entity)
    {
        return redirect(Taxonomy::uris()->make('editItems', $entity->taxonomy, adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function onDeleteSuccess(Entity $entity)
    {
        return redirect(Taxonomy::uris()->make('editItems', $entity->taxonomy, adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function onPatchSuccess(Entity $entity, Collection $entities)
    {
        return redirect(Taxonomy::uris()->make('editItems', $entities[0]->taxonomy, adminPrefix()));
    }
}
