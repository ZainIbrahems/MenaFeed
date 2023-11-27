<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformSubCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $childs = \App\Resources\PlatformSubSubCategory::collection(\App\Models\PlatformSubSubCategory::
        where('sub_category_id', $this->id)->
        orderBy('ranking', 'asc')->get());
        return [
            'id' => (int)$this->id,
            'filter_id' => 'cat_sub_'.$this->id,
            'name' => $this->name,
            'ranking' => $this->ranking,
            'design' => $this->design,
            'childs' => sizeof($childs) > 0 ? $childs : NULL
        ];
    }
}
