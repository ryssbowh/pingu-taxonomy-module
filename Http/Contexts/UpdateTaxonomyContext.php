<?php

namespace Pingu\Taxonomy\Http\Contexts;

use Pingu\Core\Http\Contexts\UpdateContext;
use Pingu\Field\Contracts\HasFieldsContract;


class UpdateTaxonomyContext extends UpdateContext
{
    /**
     * @inheritDoc
     */
    public function getValidationRules(HasFieldsContract $model): array
    {
        return $model->fieldRepository()->validationRules()->except('machineName')->toArray();
    }
}