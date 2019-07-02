<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Taxonomy\Entities\Taxonomy;

class AjaxTaxonomyController extends AjaxModelController
{
    /**
     * @inheritDoc
     */
    public function getModel()
    {
        return Taxonomy::class;
    }
}
