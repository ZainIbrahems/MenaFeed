<?php

namespace App\Resources;

use App\Models\BlogsLike;
use App\Models\BlogsShare;
use App\Models\BlogView;
use App\Models\JobsLike;
use App\Models\UserFollow;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Blog extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $data = $this->translate(app()->getLocale(), 'fallbackLocale');

        $is_mine = false;
        $is_liked = false;
        if (auth('sanctum')->check()) {
            $from_type = getUserType();
            $provider_id = auth('sanctum')->user()->id;
            $is_mine = false;
            if ($from_type == 'provider' && $this->provider_id == $provider_id) {
                $is_mine = true;
            }
            $is_liked = (bool)BlogsLike::where([
                'user_id' => $provider_id,
                'user_type' => $from_type,
                'blog_id' => $this->id,
            ])->first();
        }

        return [
            'id' => (int)$this->id,
            'banner' => getImageURL($this->banner),
            'title' => $data->title,
            'slug' => $data->slug,
            'content' => $data->content,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'provider_id' => $this->provider_id,
            'category' => $this->category ? BlogsCategory::make($this->category) : null,
            'sub_category' => $this->sub_category ? BlogsCategory::make($this->sub_category) : null,
            'provider' => $this->provider ? ProviderBref::make($this->provider) : null,
            'created_at' => Carbon::parse($this->created_at)->toDateString(),
            'view' => BlogView::where('blogs_id', $this->id)->count(),
            'share_link' => "https://menaaii.com/blogs/" . $this->id . "/" . $this->slug,
            'shares_count' => BlogsShare::where('blog_id', $this->id)->count(),
            'likes_count' => BlogsLike::where('blog_id', $this->id)->count(),
            'is_mine' => $is_mine,
            'is_liked' => $is_liked
        ];
    }
}
