<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Pingu\Entity\Entities\BaseEntity;
use Pingu\Entity\Http\Controllers\AdminEntityController;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyAdminController extends AdminEntityController
{
    public function editItems(Taxonomy $taxonomy)
    {
        \ContextualLinks::addFromObject($taxonomy);
        $item = new TaxonomyItem;

        return view('taxonomy::indexItems')->with([
            'taxonomy' => $taxonomy, 
            'items' => $taxonomy->getRootItems(),
            'addItemUri' => $item->uris()->make('create', $taxonomy, adminPrefix()),
            'deleteItemUri' => $item->uris()->make('delete', [], adminPrefix()),
            'editItemUri' => $item->uris()->make('edit', [], adminPrefix()),
            'patchItemsUri' => $taxonomy->uris()->make('patchItems', $taxonomy, adminPrefix())
        ]);
    }

    public function saveItems(Taxonomy $taxonomy)
    {
        
    }

    protected function getStoreUri(BaseEntity $entity)
    {
        return ['url' => (new TaxonomyItem)->uris()->make('store', $entity, adminPrefix())];
    }

    protected function onSuccessfullStore(BaseEntity $taxonomy)
    {
        return redirect()->route('taxonomy.admin.taxonomy');
    }
}
