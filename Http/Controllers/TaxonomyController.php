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
            'addItemUri' => TaxonomyItem::transformUri('create', $taxonomy, config('core.ajaxPrefix')),
            'deleteItemUri' => TaxonomyItem::getUri('delete', config('core.ajaxPrefix')),
            'editItemUri' => TaxonomyItem::getUri('edit', config('core.ajaxPrefix')),
            'patchItemsUri' => TaxonomyItem::getUri('patch', config('core.ajaxPrefix'))
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
