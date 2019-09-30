<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Pingu\Entity\Entities\BaseEntity;
use Pingu\Entity\Http\Controllers\AjaxEntityController;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyItemAjaxController extends AjaxEntityController
{
    protected function getStoreUri(BaseEntity $entity)
    {
        $taxonomy = $this->routeParameter(Taxonomy::routeSlug());
        return ['url' => $entity->uris()->make('store', $taxonomy, adminPrefix())];
    }

	protected function afterCreateFormCreated(Form $form, BaseEntity $entity)
	{
		$taxonomy = $this->routeParameter('taxonomy');
		$form->setFieldValue('taxonomy', $taxonomy)
			->addViewSuggestion('forms.modal')
			->isAjax()
			->option('title', 'Add a '.$entity::friendlyName());
	}
}
