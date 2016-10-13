<?php

namespace App\Transformers;

abstract class Transformer
{
    /**
     * Transform an collection.
     * @param  array  $items
     * @return array
     */
    public function transformCollection($items)
    {
        $transformed = [];
        foreach($items as $item)
        {
            $transformed[] = $this->transform($item);
        }
        return $transformed ?: null;
    }

    public abstract function transform($item);
}
