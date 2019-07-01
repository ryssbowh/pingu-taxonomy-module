<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AdminModelController;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyController extends AdminModelController
{
    public function editItems(Request $request, Taxonomy $taxonomy)
    {
        \ContextualLinks::addModelLinks($taxonomy);

        return view('taxonomy::edit-items')->with([
            'taxonomy' => $taxonomy, 
            'items' => $taxonomy->getRootItems(),
            'addItemUri' => TaxonomyItem::transformAjaxUri('create', $taxonomy, true),
            'deleteItemUri' => TaxonomyItem::getAjaxUri('delete', true),
            'editItemUri' => TaxonomyItem::getAjaxUri('edit', true),
            'patchItemsUri' => TaxonomyItem::getAjaxUri('patch', true)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function onSuccessfullStore(BaseModel $taxonomy)
    {
        return redirect()->route('taxonomy.admin.taxonomy');
    }

    /**
     * @inheritDoc
     */
    public function getModel()
    {
        return Taxonomy::class;
    }
}
