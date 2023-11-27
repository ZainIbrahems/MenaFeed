<?php

namespace App\Resources;

use App\Models\UsersField;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class SubscriptionFeature extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name
        ];
    }
}
