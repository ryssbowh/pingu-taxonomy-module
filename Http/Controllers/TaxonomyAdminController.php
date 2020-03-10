<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Http\Controllers\AdminEntityController;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyAdminController extends AdminEntityController
{
    /**
     * Edit items action
     * 
     * @param Taxonomy $taxonomy
     * 
     * @return view
     */
    public function editItems(Taxonomy $taxonomy)
    {
        \ContextualLinks::addFromObject($taxonomy);
        $item = new TaxonomyItem;

        return view('pages.taxonomy.indexItems')->with(
            [
            'taxonomy' => $taxonomy, 
            'items' => $taxonomy->getRootItems(),
            'addItemUri' => $item::uris()->make('create', $taxonomy, adminPrefix()),
            'deleteItemUri' => $item::uris()->make('delete', [], adminPrefix()),
            'editItemUri' => $item::uris()->make('edit', [], adminPrefix()),
            'patchItemsUri' => TaxonomyItem::uris()->make('patch', $taxonomy, adminPrefix())
            ]
        );
    }

    /**
     * @inheritDoc
     */
    protected function onStoreSuccess(Entity $taxonomy)
    {
        return redirect()->route('taxonomy.admin.taxonomy');
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $entity)
    {
        $form->getElement('machineName')->option('disabled', true);
    }

    /**
     * @inheritDoc
     */
    protected function afterCreateFormCreated(Form $form, Entity $entity)
    {
        $field = $form->getElement('machineName');
        $field->classes->add('js-dashify');
        $field->option('data-dashifyfrom', 'name');
    }
}
