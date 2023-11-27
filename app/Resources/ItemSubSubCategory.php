<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemSubSubCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $childs = [];

        return [
            'id' => (int)$this->id,
//            'filter_id' => 'item_cat_sub_sub_'.$this->id,
            'name' => $this->name,
            'image' => getImageURL($this->image),
//            'ranking' => $this->ranking,
//            'design' => $this->design,
            'childs' => sizeof($childs) > 0 ? $childs : NULL
        ];
    }
}
