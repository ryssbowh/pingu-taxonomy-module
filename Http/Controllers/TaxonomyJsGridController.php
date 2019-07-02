<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Jsgrid\Http\Controllers\JsGridModelController;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyJsGridController extends JsGridModelController
{
    /**
     * @inheritDoc
     */
    public function getModel(): string
    {
        return Taxonomy::class;
    }

    /**
     * @inheritDoc
     */
    protected function canClick()
    {
        return \Auth::user()->can('edit taxonomy vocabularies');
    }

    /**
     * @inheritDoc
     */
    protected function canDelete()
    {
        return \Auth::user()->can('delete taxonomy vocabularies');
    }

    /**
     * @inheritDoc
     */
    protected function canEdit()
    {
        return $this->canClick();
    }

    /**
     * @inheritDoc
     */
    public function index(Request $request)
    {
        $options['jsgrid'] = $this->buildJsGridView($request);
        $options['title'] = str_plural(Taxonomy::friendlyName());
        $options['canSeeAddLink'] = \Auth::user()->can('add menus');
        $options['addLink'] = Taxonomy::getAdminUri('create', true);
        
        return view('pages.listModel-jsGrid', $options);
    }

}
