<?php
namespace Bestlang\Base\Mixins;

class Collection
{
    /**
     * @return \Closure
     * 为了让无children的节点不包含·children·属性
     */
    public function treeSelect()
    {
        return function () {
            $dict = $this->sortBy(function ($node) {
                return $node->getOrder();
            })->each(function ($node) {
                $node->setRelation('children', new static);
            })->getDictionary();
            $nestedKeys = [];
            foreach ($dict as $key => $node) {
                $parentKey = $node->getParentKey();
                if (!is_null($parentKey) && array_key_exists($parentKey, $dict)) {
                    if(!isset( $dict[$parentKey]->children)){
                        $dict[$parentKey]->children = [];
                    }
                    if(!count($node->children)){
                        unset($node->children);
                    }
                    $dict[$parentKey]->children[] = $node;
                    $nestedKeys[] = $node->getKey();
                }
            }
            foreach ($nestedKeys as $key) {
                unset($dict[$key]);
            }
            return new static($dict);
        };
    }
}