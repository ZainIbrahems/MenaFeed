<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class Example extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {


        $liked = false;
        if (auth('sanctum')->user()) {
            $liked = \App\Models\LikedArticle::where([
                'user_id' => auth('sanctum')->user()->id,
                'article_id' => $this->id,
            ])->first()?true:false;
        }


        $data = $this->translate(app()->getLocale(), 'fallbackLocale');

        return [
            'id' => (int)$data->id,
            'full_name' => $data->full_name,
            'email' => $data->email,
            'title' => $data->title,
            'content' => $data->content,
            'short_description' => $data->short_description,
            'liked' => $liked,
            'added_by' => $data->added_by_user ? ($data->added_by_user->f_name . ' ' . $data->added_by_user->l_name) : '',
            'image' => getImageURL($data->image),
        ];
    }
}
