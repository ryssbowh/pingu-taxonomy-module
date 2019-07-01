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
     * Adds the taxonomy id (coming from the request path) to the store uri
     * @return string
     */
    protected function getStoreUri()
	{
		$taxonomy = $this->request->route()->parameters()['taxonomy'];
		return TaxonomyItem::transformAjaxUri('store', [$taxonomy], true);
	}

	/**
	 * Add the taxonomy as a hidden field in the create form
	 * @param  Form    $form
	 */
    public function afterStoreFormCreated(Form $form)
	{
		$taxonomy = $this->request->route()->parameter('taxonomy');
		$form->setFieldValue('taxonomy', $taxonomy);
	}

	/**
	 * Bulk update for taxonomy items
	 * @return array
	 */
	public function patch()
	{
		$post = $this->request->post();
		if(!isset($post['models'])){
			throw new HttpException(422, "'models' must be set for a patch request");
		}
		$model = $this->getModel();
		$model = new $model;
		$models = collect();
		$this->saveItems($post['models']);
		return ['message' => 'Items have been updated'];
	}

	protected function saveItems($itemsData, $parent = null)
	{
		foreach($itemsData as $weight => $data){
			$item = TaxonomyItem::findOrFail($data['id']);
			$item->weight = $data['weight'];
			$item->parent()->dissociate();
			if($parent){
				$item->parent()->associate($parent);
			}
			$item->save();
			if(isset($data['children'])){
				$this->saveItems($data['children'], $data['id']);
			}
		}
	}
}
