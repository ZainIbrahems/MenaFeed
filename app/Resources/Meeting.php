<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Meeting extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $is_mine = false;
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $slug = auth('sanctum')->user()->type_str;
            if ($this->user_id == $user_id && $this->slug == $slug) {
                $is_mine = true;
            }
        }

        return [
            'id' => (int)$this->id,
            'title' => $this->title,
            'date' => Carbon::parse($this->date)->toDateTimeString(),
            'from' => Carbon::parse($this->from)->toDateTimeString(),
            'to' => Carbon::parse($this->to)->toDateTimeString(),
            'duration' => Carbon::parse($this->to)->diffInMinutes(Carbon::parse($this->from)->toTimeString()),
            'time_zone' => $this->time_zone,
            'repeat' => [
                'id' => $this->repeat,
                'title' => trans("messages." . $this->repeat)
            ],
            'require_passcode' => $this->require_passcode,
            'passcode' => $this->passcode,
            'waiting_room' => $this->waiting_room,
            'partipant_before_host' => $this->partipant_before_host,
            'auto_record' => $this->auto_record,
            'to_calendar' => $this->to_calendar,
            'share_permission' => $this->share_permission,
            'publish_to_feed' => $this->publish_to_feed,
            'publish_to_live' => $this->publish_to_live,
            'is_mine' => $is_mine,
            'participants_type' => $this->participants_type ?
                MeetingParticipantsType::make(\App\Models\MeetingParticipantsType::where('id', $this->participants_type)->first()) : null,
            'meeting_type' => $this->meeting_type ?
                MeetingType::make(\App\Models\MeetingType::where('id', $this->meeting_type)->first()) : null,
        ];
    }
}
