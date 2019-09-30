<?php

namespace Pingu\Taxonomy\Entities\Uris;

use Pingu\Entity\Support\BaseEntityUris;

class TaxonomyUris extends BaseEntityUris
{
	/**
     * Uri for editing items
     *
     * @return string
     */
    public function editItems()
    {
        return $this->object::routeSlug().'/{'.$this->object::routeSlug().'}/items';
    }

    /**
     * Uri for editing items
     *
     * @return string
     */
    public function patchItems()
    {
        return $this->editItems();
    }
}