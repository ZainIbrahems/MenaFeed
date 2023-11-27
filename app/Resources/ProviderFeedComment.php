<?php

namespace App\Resources;

use App\Models\ProviderFeedCommentLike;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderFeedComment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->user_type == 'client') {
            $user = \App\Models\Client::where('id', $this->user_id)->first();
        } else {
            $user = \App\Models\Provider::where('id', $this->user_id)->first();
        }


        $is_liked = false;
        $is_disliked = false;
        if (auth('sanctum')->check()) {
            $is_liked = (bool)ProviderFeedCommentLike::where([
                'user_id' => auth('sanctum')->user()->id,
                'user_type' => getUserType(),
                'is_like' => 1,
                'comment_id' => $this->id,
            ])->first();
            $is_disliked = (bool)ProviderFeedCommentLike::where([
                'user_id' => auth('sanctum')->user()->id,
                'user_type' => getUserType(),
                'is_like' => 0,
                'comment_id' => $this->id,
            ])->first();
        }

        return [
            'id' => (int)$this->id,
            'user' => $user ? ($this->user_type == 'client' ? Client::make($user) : Provider::make($user)) : null,
            'comment' => $this->comment,
            'is_liked' => $is_liked,
            'is_disliked' => $is_disliked,
            'likes_count' => ProviderFeedCommentLike::where([
                'is_like' => 1,
                'comment_id' => $this->id,
            ])->count(),
            'dislikes_count' => ProviderFeedCommentLike::where([
                'is_like' => 0,
                'comment_id' => $this->id,
            ])->count(),
            'replies' => ProviderFeedComment::collection($this->replies),
            'created_at' => Carbon::parse($this->updated_at)->toDateTimeString()
        ];
    }
}
