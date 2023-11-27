<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $chat = \App\Models\Chat::where('id', $this->chat_id)->first();

        $is_you = false;

        $from = null;
        if ($chat->from_type == 'client') {
            $from = \App\Models\Client::where('id', $chat->from_id)->withTrashed()->first();
        } else {
            $from = \App\Models\Provider::where('id', $chat->from_id)->withTrashed()->first();
        }
        $from_name = $from ? $from->full_name : '';

        $to = null;
        if ($chat->to_type == 'client') {
            $to = \App\Models\Client::where('id', $chat->to_id)->withTrashed()->first();
        } else {
            $to = \App\Models\Provider::where('id', $chat->to_id)->withTrashed()->first();
        }
        $to_name = $to ? $to->full_name : '';

        if (auth('sanctum')->user()->id == $this->from_id) {
            $is_you = true;
        }

        $files = json_decode($this->files);
        $files_temp = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                $files_temp[] = [
                    'path' => getImageURL($file->path),
                    'type' => $file->type
                ];
            }
        }

        $read_at = NULL;
        if (auth('sanctum')->check() && auth('sanctum')->user()->id == $this->to_id) {
            $read_at = Carbon::now()->toDateTimeString();
            if ($this->read_at == NULL) {
                \App\Models\Message::where('id', $this->id)->update([
                    'read_at' => $read_at
                ]);
            } else {
                $read_at = Carbon::parse($this->read_at)->toDateTimeString();
            }
        }

        return [
            'id' => (int)$this->id,
            'message' => $this->message,
            'files' => $files_temp,
//            'file' => $this->file ? asset('storage/' . $this->file) : NULL,
            'type' => $this->type,
            'from_id' => $this->from_id,
            'from_name' => $from_name,
            'is_you' => $is_you,
            'to_id' => $this->to_id,
            'to_name' => $to_name,
            'message_type' => $this->type,
            'receive_type' => ($this->read_at != NULL ? '2' : '1'),
            'read_at' => $read_at,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'from' => User::make($from),
            'to' => User::make($to),
        ];
    }
}
