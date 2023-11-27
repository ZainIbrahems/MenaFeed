<?php

namespace App\Resources;

use App\Models\ProviderFeedComment;
use App\Models\ProviderFeedLike;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderFeedsTopic extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
        ];
    }
}
