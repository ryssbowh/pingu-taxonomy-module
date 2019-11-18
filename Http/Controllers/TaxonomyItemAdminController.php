<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Illuminate\Support\Collection;
use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Http\Controllers\AdminEntityController;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemAdminController extends AdminEntityController
{
    protected function getStoreUri(Entity $entity)
    {
        $taxonomy = $this->routeParameter(Taxonomy::routeSlug());
        return ['url' => $entity->uris()->make('store', $taxonomy, adminPrefix())];
    }

    protected function afterCreateFormCreated(Form $form, Entity $entity)
    {
        $taxonomy = $this->routeParameter('taxonomy');
        $form->getElement('taxonomy')->setValue($taxonomy->id);
    }

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
