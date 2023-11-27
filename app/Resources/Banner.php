<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Banner extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        try {
            $img_size =public_path('storage') . '/' . $this->image;
            try {
                $sizes = getimagesize($img_size);
            } catch (\Exception $ex) {
                $sizes = [200, 200];
            }
        } catch (\Exception $ex) {
            $sizes = [];
        }

        $images_style = sizeof($sizes) > 1 ? ($sizes[1] / $sizes[0]) : 1;

        return [
            'id' => (int)$this->id,
            'title' => $this->title,
            'platform_id' => $this->platform_id,
            'url' => $this->url,
            'resource_type' => $this->resource_type,
            'resource_id' => $this->resource_id,
            'image' => getImageURL($this->image),
            'images_style' => round($images_style, 2),
        ];
    }
}
