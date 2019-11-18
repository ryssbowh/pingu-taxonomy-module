<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Http\Controllers\AjaxEntityController;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemAjaxController extends AjaxEntityController
{
    /**
     * @inheritDoc
     */
    protected function getStoreUri(Entity $entity)
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
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->option('title', 'Add a '.$entity::friendlyName());
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $entity)
    {
        $form->removeElements(['parent', 'weight']);
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->option('title', 'Add a '.$entity::friendlyName());
    }
}
