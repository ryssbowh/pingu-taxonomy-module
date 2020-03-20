<?php

namespace Pingu\Taxonomy\Validation;

use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;

class TaxonomyRules
{
    /**
     * Rules that checks if a taxonomy belongs to a vocabulary
     * 
     * @param mixed $attribute
     * @param mixed $value
     * @param mixed $vocabulary
     * @param mixed $validator
     * 
     * @return bool
     */
    public function vocabulary($attribute, $value, $vocabulary, $validator)
    {
        if (!is_numeric($vocabulary[0])) {
            $taxonomy = Taxonomy::findByMachineName($vocabulary[0]);
        } else {
            $taxonomy = Taxonomy::find($vocabulary[0]);
        }
        if (!$taxonomy) {
            return false;
        }
        $item = TaxonomyItem::find($value);
        if (is_null($item)) {
            return false;
        }
        if ($item->taxonomy->id != $taxonomy->id) {
            return false;
        }
        return true;
    }
}