<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class AjaxItemController extends AjaxModelController
{

    /**
     * @inheritDoc
     */
    public function getModel(): string
    {
        return TaxonomyItem::class; 
    }

    /**
	 * @inheritDoc
	 */
    protected function getStoreUri()
	{
		$taxonomy = $this->request->route()->parameters()['taxonomy'];
		return TaxonomyItem::makeUri('store', [$taxonomy], ajaxPrefix());
	}

	/**
	 * @inheritDoc
	 */
    public function afterStoreFormCreated(Form $form)
	{
		$taxonomy = $this->request->route()->parameter('taxonomy');
		$form->addHiddenField('taxonomy', $taxonomy->id);
	}

	/**
	 * @inheritDoc
	 */
	protected function performStore(BaseModel $model, array $validated){
		$taxonomy = $this->request->route()->parameters()['taxonomy'];
		$validated['taxonomy'] = $taxonomy->id;
		$model->saveWithRelations($validated);
		return $model;
	}

}
