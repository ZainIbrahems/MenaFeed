<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Chat extends JsonResource
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

        $last_message_from = NULL;
        if ($from) {
            if ($this->last_message_from == $from->id) {
                $last_message_from = $from;
            } else {
                $last_message_from = $to;
            }
        }

        $num_unread = 0;
        if ($current_user) {
            $num_unread = \App\Models\Message::where('chat_id', $this->id)
                ->where('to_id', $current_user->id)->where('read_at', NULL)->count();
        }

        $last_message = \App\Models\Message::where('chat_id', $this->id)
            ->where('to_id', '<>', $current_user->id)
            ->orderBy('id', 'desc')->first();

        $receive_type = "0";
        if ($last_message && $last_message->read_at != NULL) {
            $receive_type = "2";
        } else {
            $receive_type = "1";
        }


        return [
            'id' => (int)$this->id,
            'last_message' => $this->last_message,
            'is_blocked' => $this->is_blocked,
            'num_unread' => $num_unread,
            'message_type' => $this->message_type,
            'receive_type' => $receive_type,
            'last_message_from' => $last_message_from ? $last_message_from->full_name : '',
            'created_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
            'user' => $other_user ? ($other_type == 'client' ? Client::make($other_user) : Provider::make($other_user)) : null,
        ];
    }
}
