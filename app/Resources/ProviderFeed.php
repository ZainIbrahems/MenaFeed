<?php

namespace App\Resources;

use App\Models\ProviderFeedComment;
use App\Models\ProviderFeedLike;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderFeed extends JsonResource
{
    public function toArray($request)
    {
        $is_liked = false;
        $is_mine = false;
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $from_type = getUserType();

            $is_liked = (bool)ProviderFeedLike::where([
                'user_id' => $user_id,
                'user_type' => $from_type,
                'feed_id' => $this->id,
            ])->first();

            $is_mine = (auth('sanctum')->user()->id == $this->provider_id) ? true : false;
        }

        $feed = \App\Models\ProviderFeed::where('id', $this->id)->first();
        $feed->feed_views = $feed->feed_views + 1;
        $feed->update();

        $files = json_decode($this->file);
        $files_temp = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                $files_temp[] = [
                    'path' => getImageURL($file->path),
                    'type' => $file->type
                ];
            }
        }

        return [
            'id' => (int)$this->id,
            'text' => $this->text,
            'files' => $files_temp,
            'type' => $this->type,
            'audience' => $this->audience,
            'lat' => strval($this->lat),
            'lng' => strval($this->lng),
            'can_comment' => $this->can_comment,
            'comments' => $this->comments->count(),
            'likes' => $this->likes->count(),
            'is_liked' => $is_liked,
            'is_mine' => $is_mine,
            'views' => $this->feed_views + 1,
            'top_10_comments' => \App\Resources\ProviderFeedComment::collection(ProviderFeedComment::
            where('feed_id', $this->id)->where('comment_id', NULL)->skip(0)->take(1)->orderBy('id', 'desc')->get()),
            'user' => ProviderBref::make($this->provider),
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString()
        ];
    }
}
