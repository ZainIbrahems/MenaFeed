<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatOnline extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {


        $from_type = 'client';
        if ($this->from_type == 'client') {
            $from = \App\Models\Client::where('id', $this->from_id)->first();
        } else {
            $from_type = 'provider';
            $from = \App\Models\Provider::where('id', $this->from_id)->first();
        }

        $to_type = 'client';
        if ($this->to_type == 'client') {
            $to = \App\Models\Client::where('id', $this->to_id)->first();
        } else {
            $to_type = 'provider';
            $to = \App\Models\Provider::where('id', $this->to_id)->first();
        }

        $current_user = auth('sanctum')->user();
        $other_type = 'provider';
        if ($current_user) {
            if ($current_user->id == $this->from_id) {
                $other_type = $to_type;
                $other_user = $to;
            } else {
                $other_type = $from_type;
                $other_user = $from;
            }
        }

        if ($from) {
            if ($this->last_message_from == $from->id) {
                $last_message_from = $from;
            } else {
                $last_message_from = $to;
            }
        }

        $user = $other_user ? ($other_type == 'client' ? Client::make($other_user) : Provider::make($other_user)) : null;

        return [
            'id' => $user ? (int)$user->id : null,
            'user' => $other_user ? ($other_type == 'client' ? Client::make($other_user) : Provider::make($other_user)) : null,
            'chat_id' => (int)$this->id,
            'personal_picture' => $user ? getImageURL($user->personal_picture) : \Voyager::image(setting('admin.bg_image')),
            'full_name' => $user ? $user->full_name : '---',
            'abbreviation' => $user ? ($user->abbreviation ? $user->abbreviation->name : '') : '',
        ];
    }
}
