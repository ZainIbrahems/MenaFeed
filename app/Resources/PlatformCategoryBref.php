<?php

namespace App\Resources;

use App\Models\PlatformSubCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatformCategoryBref extends JsonResource
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
            'filter_id' => 'cat_'.$this->id,
            'image' => getImageURL($this->image),
            'name' => $this->name,
            'ranking' => $this->ranking,
            'design' => $this->design,
            'childs' => sizeof($childs) > 0 ? $childs : NULL
        ];
    }
}
