<?php

namespace Pingu\Taxonomy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AdminModelController;
use Pingu\Forms\Support\Form;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class AdminItemController extends AdminModelController
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
		return TaxonomyItem::makeUri('store', [$taxonomy], adminPrefix());
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

	/**
	 * @inheritDoc
	 */
	protected function onSuccessfullStore(BaseModel $model){
		return redirect(Taxonomy::makeUri('editItems', $model->taxonomy, adminPrefix()));
	}

	/**
	 * @inheritDoc
	 */
	protected function onUpdateSuccess(BaseModel $model){
		return redirect(Taxonomy::makeUri('editItems', $model->taxonomy, adminPrefix()));
	}

	/**
	 * @inheritDoc
	 */
	protected function onSuccessfullDeletion(BaseModel $model){
		return redirect(Taxonomy::makeUri('editItems', $model->taxonomy, adminPrefix()));
	}

	/**
	 * @inheritDoc
	 */
	protected function onSuccessfullPatch(Collection $models){
		return redirect(Taxonomy::makeUri('editItems', $models[0]->taxonomy, adminPrefix()));
	}

}
