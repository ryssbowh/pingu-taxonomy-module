<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Pingu\Entity\Http\Controllers\EntityCrudContextController;
use Pingu\Entity\Support\Entity;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyController extends EntityCrudContextController
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
        \ContextualLinks::addObjectActions($taxonomy, 'admin');

        return view('pages.taxonomy.indexItems')->with(
            [
            'taxonomy' => $taxonomy, 
            'items' => $taxonomy->getRootItems(),
            'addItemUri' => TaxonomyItem::uris()->make('create', $taxonomy, adminPrefix()),
            'deleteItemUri' => TaxonomyItem::uris()->make('delete', [], adminPrefix()),
            'editItemUri' => TaxonomyItem::uris()->make('edit', [], adminPrefix()),
            'patchItemsUri' => TaxonomyItem::uris()->make('patch', $taxonomy, adminPrefix())
            ]
        );
    }
}
