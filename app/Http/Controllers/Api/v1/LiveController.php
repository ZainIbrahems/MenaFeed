<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Live;
use App\Models\LiveNowCategory;
use App\Models\LiveReport;
use App\Models\Livestream;
use App\Models\LiveTopic;
use App\Models\Provider;
use App\Models\ProviderLivestream;
use App\Models\UpcomingLivestream;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Http\Controllers\ContentTypes\MultipleImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class LiveController extends Controller
{
    public function setLive()
    {
        $provider = Provider::where('id', auth('sanctum')->user()->id)->first();
        if ($provider) {
            $provider->is_live = 1;
            $provider->update();
            $last_live = Live::where('added_by', $provider->id)->orderBy('id', 'desc')->first();
            if ($last_live) {
                Live::where('id', $last_live->id)->update([
                    'status' => 1
                ]);
            }
        }
        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }

    public function setNotLive()
    {
        $provider = Provider::where('id', auth('sanctum')->user()->id)->first();
        if ($provider) {
            $provider->is_live = 0;
            $provider->update();
            $last_live = Live::where('added_by', $provider->id)->orderBy('id', 'desc')->first();
            if ($last_live) {
                Live::where('id', $last_live->id)->update([
                    'status' => 0
                ]);
            }
        }
        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }

    public function goLive(Request $request)
    {

        \Log::info($request->all());
        $validator = Validator::make(request()->all(), [
            'topic_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            \Log::info($validator->getMessageBag());
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        Live::where([
            'added_by' => auth('sanctum')->user()->id
        ])->update([
            'status' => 0
        ]);


        $lv = new Live();
//        $lv->duration = 60;
        if ($request->hasFile('image')) {
            $slug = 'lives';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'image')->first();
            $lv->image = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }
        $u_id = uniqid('mena_');
        do {
            $added_before = Live::where('code', '=', $u_id)->first() ? true : false;
            if (!$added_before) {
                $lv->code = $u_id;
            } else {
                $u_id = uniqid('mena_');
            }
        } while ($added_before);
        $lv->title = request()->has('title') ? request()->get('title') : "";
        $lv->goal = request()->has('goal') ? request()->get('goal') : "";
        $lv->topic_id = request()->get('topic_id');
        $lv->live_now_category_id = request()->has('live_now_category_id') ? request()->get('live_now_category_id') : NULL;
        $lv->status = 1;
        $lv->platform_id = auth('sanctum')->user()->platform_id;
        $lv->added_by = auth('sanctum')->user()->id;

        $lv->save();

        $pl = new ProviderLivestream();
        $pl->live_id = $lv->id;
        $pl->provider_id = auth('sanctum')->user()->id;
        $pl->save();

        return parent::sendSuccess(trans('messages.Data Got!'), \App\Resources\Live::make($lv));
    }

    public function report(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'live_id' => 'required|numeric',
            'content' => 'required|string|min:2|max:1500',
        ]);

        if ($validator->fails()) {
            \Log::info($validator->getMessageBag());
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }


        $lv = Live::where('id', $request->get('live_id'))->orWhere('code', $request->get('live_id'))->first();

        if ($lv) {
            $pl = new LiveReport();

            $images = [];
            $slug = 'live-reports';
            if ($request->hasFile('images')) {
                $data_type = DataType::where('slug', $slug)->first();
                $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'images')->first();
                $images = (new MultipleImage($request, $slug, $row, $row->details))->handle();
            }

            $pl->live_id = $lv->id;
            $pl->user_id = auth('sanctum')->user()->id;
            $pl->content = $request->get('content');
            $pl->images = $images;
            $pl->save();

            try {
                Mail::send('emails.report-live', ['live' => $lv, 'content' => $pl->content], function ($message) {
                    $message->to('security@menaai.ae', 'Mena')->subject
                    ('Mena Live Report');
                    $message->from('security@menaai.ae', 'Mena');
                });
            } catch (\Exception $ex) {

            }

            return parent::sendSuccess(trans('messages.Data Saved!'), null);
        } else {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }
    }

    public function getCategories()
    {
        $data = [];
        $data['live_now'] = LiveNowCategory::query();
        $data['upcoming'] = LiveNowCategory::query();

        if (request()->has('platform_id')) {
            $data['live_now'] = $data['live_now']->where('platform_id', request()->get('platform_id'))->where('type', 'live_now');
            $data['upcoming'] = $data['upcoming']->where('platform_id', request()->get('platform_id'))->where('type', 'upcoming');
        }

        $data['live_now'] = $data['live_now']->get();
        $data['upcoming'] = $data['upcoming']->get();

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function info()
    {
        $data = [];
        $data['topics'] = LiveNowCategory::query();

        $data['live_now'] = LiveNowCategory::query();
        if (request()->has('platform_id')) {
            $data['live_now'] = $data['live_now']->where('platform_id', request()->get('platform_id'));
        }
        if (request()->has('platform_id')) {
            $data['topics'] = $data['topics']->where('platform_id', request()->get('platform_id'));
        }

        $data['live_now'] = \App\Resources\LiveNowCategory::collection($data['live_now']->get()->translate(app()->getLocale(), 'fallbackLocale'));
        $data['topics'] = \App\Resources\LiveTopic::collection($data['topics']->get()->translate(app()->getLocale(), 'fallbackLocale'));

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getLiveCategories()
    {
        $data = LiveNowCategory::query();

        if (request()->has('platform_id')) {
            $data = $data->where('platform_id', request()->get('platform_id'));
        }

        $data = $data->get();
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getUpcomingCategories()
    {
        $data = LiveNowCategory::where('type', 'upcoming');

        if (request()->has('platform_id')) {
            $data = $data->where('platform_id', request()->get('platform_id'));
        }

        $data = $data->get();
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }


    public function getLives(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $lives = getProviderNearByLiveStream($request);


        $lives_by_category = Live::query();
        if ($request->has('category_id') && $request->get('category_id') != -1) {
            $lives_by_category = $lives_by_category->where('live_now_category_id', $request->get('category_id'));
        }
        if ($request->has('topic_id') && $request->get('topic_id') != -1) {
            $lives_by_category = $lives_by_category->where('topic_id', $request->get('topic_id'));
        }
        $lives_by_category = $lives_by_category->
        where('status', 1)->
        has('provider')->
        orderBy('id', 'desc')->
        paginate($limit, ['*'], 'page', $offset);
        $lives_by_category_data = \App\Resources\Live::collection($lives_by_category->all());

        $data = [
            'lives' => $lives,
            'lives_by_category' => [
                'total_size' => $lives_by_category->total(),
                'limit' => (int)$limit,
                'offset' => (int)$offset,
                'data' => $lives_by_category_data
            ]
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getLiveDetails($code)
    {

        $data = Live::
        where('code', $code)->
        where('status', 1)->
        has('provider')->first();

        if ($data) {
            return parent::sendSuccess(trans('messages.Data Got!'), \App\Resources\Live::make($data));
        } else {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }
    }


}
