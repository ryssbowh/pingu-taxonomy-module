<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Http\Controllers\AjaxEntityController;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemAjaxController extends AjaxEntityController
{
    /**
     * @inheritDoc
     */
    protected function getStoreUri(Entity $entity, ?BundleContract $bundle)
    {
        $taxonomy = $this->routeParameter(Taxonomy::routeSlug());
        return ['url' => $entity->uris()->make('store', $taxonomy, adminPrefix())];
    }

    /**
     * @inheritDoc
     */
    protected function afterCreateFormCreated(Form $form, Entity $entity)
    {
        $taxonomy = $this->routeParameter('taxonomy');
        $form->getElement('taxonomy')->setValue($taxonomy->id);
        $form->removeElements(['parent', 'weight']);
        $form->isAjax()
            ->option('title', 'Add a '.$entity::friendlyName());
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $entity)
    {
        $form->removeElements(['parent', 'weight']);
        $form->isAjax()
            ->option('title', 'Add a '.$entity::friendlyName());
    }
}
