<?php

namespace Pingu\Taxonomy\Entities\Actions;

use Pingu\Entity\Contracts\Actions;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyActions extends Actions
{
	public function actions(): array
	{
		return [
			'edit' => [
				'label' => 'Edit',
				'url' => $this->object->uris()->make('edit', $this->object, adminPrefix())
			],
			'editItems' => [
                'label' => 'List items',
                'url' => $this->object->uris()->make('editItems', $this->object, adminPrefix())
            ],
            'delete' => [
				'label' => 'Delete',
				'url' => $this->object->uris()->make('confirmDelete', $this->object, adminPrefix())
			],
		];
	}

	public function editAccess()
	{
		return \Auth::user()->hasPermissionTo('edit taxonomy vocabularies');
	}

	public function deleteAccess()
	{
		return \Auth::user()->hasPermissionTo('delete taxonomy vocabularies');
	}

	public function editItemsAccess()
	{
		return \Auth::user()->hasPermissionTo('view taxonomy terms');
	}
}