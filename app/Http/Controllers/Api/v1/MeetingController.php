<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Resources\MeetingParticipantsType;
use App\Resources\MeetingType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class MeetingController extends Controller
{

    public function my(Request $request)
    {
        $data = Meeting::select('date')->where([
            'user_id' => auth('sanctum')->user()->id,
            'slug' => auth('sanctum')->user()->type_str
        ])->orderBy('date', 'asc')->groupBy('date')->get();

        $result = [];

        foreach ($data as $d) {
            $data2 = Meeting::where([
                'user_id' => auth('sanctum')->user()->id,
                'slug' => auth('sanctum')->user()->type_str
            ])->where('date', $d->date)->orderBy('date', 'asc')->get();
            $meetings = [];
            foreach ($data2 as $dd) {
                $meetings[] = \App\Resources\Meeting::make($dd);
            }

            $result[] = [
                'date' => Carbon::parse($d->date)->toDateTimeString(),
                'meetings' => $meetings,
            ];
        }


        return parent::sendSuccess(trans('messages.Data Deleted!'), $result);
    }

    public function start(Request $request)
    {
        $data = [];
        $data['repeat'] = [
            [
                'id' => "none",
                'title' => trans("messages.none")
            ],
            [
                'id' => "every_day",
                'title' => trans("messages.every_day")
            ],
            [
                'id' => "every_week",
                'title' => trans("messages.every_week")
            ],
            [
                'id' => "every_2_week",
                'title' => trans("messages.every_2_week")
            ],
            [
                'id' => "every_month",
                'title' => trans("messages.every_month")
            ],
            [
                'id' => "every_year",
                'title' => trans("messages.every_year")
            ]
        ];
        $data['time_zones'] = getTimeZones();
        $data['meeting_types'] = MeetingType::collection(\App\Models\MeetingType::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $data['participants_types'] = MeetingParticipantsType::collection(\App\Models\MeetingParticipantsType::get()->translate(app()->getLocale(), 'fallbackLocale'));
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passcode' => 'required|string',
            'title' => 'required|string',
            'date' => 'required|date',
            'from' => 'required|string',
            'to' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $app = new Meeting();
        $app->user_id = auth('sanctum')->user()->id;
        $app->slug = auth('sanctum')->user()->type_str;
        $app->passcode = $request->get('passcode');
        $app->title = $request->get('title');
        $app->date = $request->get('date');
        $app->from = $request->get('from');
        $app->to = $request->get('to');
        $app->time_zone = $request->get('time_zone');
        $app->repeat = $request->get('repeat');
        $app->require_passcode = $request->get('require_passcode');
        $app->waiting_room = $request->get('waiting_room');
        $app->partipant_before_host = $request->get('partipant_before_host');
        $app->auto_record = $request->get('auto_record');
        $app->to_calendar = $request->get('to_calendar');
        $app->share_permission = $request->get('share_permission');
        $app->publish_to_feed = $request->get('publish_to_feed');
        $app->publish_to_live = $request->get('publish_to_live');
        $app->participants_type = $request->get('participants_type');
        $app->meeting_type = $request->get('meeting_type');
        $app->save();
        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }

    public function delete(Request $request)
    {

        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = Meeting::where([
            'id' => $request->id,
            'user_id' => auth('sanctum')->user()->id,
            'slug' => auth('sanctum')->user()->type_str
        ])->first();
        if ($data) {
            Meeting::where([
                'id' => $request->id,
                'user_id' => auth('sanctum')->user()->id,
                'slug' => auth('sanctum')->user()->type_str
            ])->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $app = Meeting::where('id', $request->get('id'))->first();
        $app->title = $request->has('title') ? $request->get('title') : $app->title;
        $app->from = $request->has('from') ? $request->get('from') : $app->from;
        $app->to = $request->has('to') ? $request->get('to') : $app->to;
        $app->time_zone = $request->has('time_zone') ? $request->get('time_zone') : $app->time_zone;
        $app->repeat = $request->has('repeat') ? $request->get('repeat') : $app->repeat;
        $app->require_passcode = $request->has('require_passcode') ? $request->get('require_passcode') : $app->require_passcode;
        $app->waiting_room = $request->has('waiting_room') ? $request->get('waiting_room') : $app->waiting_room;
        $app->partipant_before_host = $request->has('partipant_before_host') ? $request->get('partipant_before_host') : $app->partipant_before_host;
        $app->auto_record = $request->has('auto_record') ? $request->get('auto_record') : $app->auto_record;
        $app->to_calendar = $request->has('to_calendar') ? $request->get('to_calendar') : $app->to_calendar;
        $app->share_permission = $request->has('share_permission') ? $request->get('share_permission') : $app->share_permission;
        $app->publish_to_feed = $request->has('publish_to_feed') ? $request->get('publish_to_feed') : $app->publish_to_feed;
        $app->publish_to_live = $request->has('publish_to_live') ? $request->get('publish_to_live') : $app->publish_to_live;
        $app->participants_type = $request->has('participants_type') ? $request->get('participants_type') : $app->participants_type;
        $app->meeting_type = $request->has('meeting_type') ? $request->get('meeting_type') : $app->meeting_type;
        $app->save();
        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }
}
