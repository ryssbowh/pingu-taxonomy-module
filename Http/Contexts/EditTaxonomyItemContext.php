<?php

namespace Pingu\Taxonomy\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Http\Contexts\EditContext;

class EditTaxonomyItemContext extends EditContext
{   
    /**
     * @inheritDoc
     */
    public static function scope(): string
    {
        return 'ajax.edit';
    }

    /**
     * @inheritDoc
     */
    public function getFields(): Collection
    {
        return $this->object->fieldRepository()->except(['parent', 'weight']);
    }
}