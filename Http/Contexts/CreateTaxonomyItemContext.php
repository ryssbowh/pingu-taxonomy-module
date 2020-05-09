<?php

namespace Pingu\Taxonomy\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Http\Contexts\CreateContext;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;

class CreateTaxonomyItemContext extends CreateContext
{
    /**
     * Get the taxonomy from request
     * 
     * @return Taxonomy
     */
    protected function getTaxonomyFromRequest()
    {
        return request()->route(Taxonomy::routeSlug());
    }

    /**
     * @inheritDoc
     */
    public function getFormAction(): array
    {
        $taxonomy = $this->getTaxonomyFromRequest();
        return ['url' => $this->object::uris()->make('store', $taxonomy, $this->getRouteScope())];
    }

    /**
     * @inheritDoc
     */
    public function getForm(): Form
    {
        $form = parent::getForm();
        $taxonomy = $this->getTaxonomyFromRequest();
        $form->getElement('taxonomy')->setValue($taxonomy->id);
        return $form;
    }
}