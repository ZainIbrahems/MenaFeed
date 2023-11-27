<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobsLike;
use App\Models\ProviderFeedLike;
use App\Resources\JobsClassification;
use App\Resources\JobsType;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\ContentTypes\File;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Validator;

class JobsController extends Controller
{

    public function getInfo(Request $request)
    {
        $data = [];

        $data['types'] = JobsType::collection(\App\Models\JobsType::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $data['classifications'] = JobsClassification::collection(\App\Models\JobsClassification::get()->translate(app()->getLocale(), 'fallbackLocale'));

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getAll(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;


        $data = Job::query();

        if ($request->has('type_id') && is_numeric($request->has('type_id'))) {
            $data = $data->where('type_id', $request->get('type_id'));
        }

        if ($request->has('classification_id') && is_numeric($request->has('classification_id'))) {
            $data = $data->where('classification_id', $request->get('classification_id'));
        }

        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\JobBref::collection($data->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getDetails($id, Request $request)
    {

        $data = Job::where('id', $id)->first();

        return parent::sendSuccess(trans('messages.Data Got!'), $data ? \App\Resources\Job::make($data) : null);
    }

    public function my(Request $request)
    {

        $data = [];

        $from_type = getUserType();
        $provider_id = auth('sanctum')->user()->id;
        if ($from_type == 'provider') {
            $data = Job::where('provider_id', $provider_id)->get();
        }

        return parent::sendSuccess(trans('messages.Data Got!'), $data ? \App\Resources\JobBref::collection($data) : null);
    }

    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'short_description' => 'required|string',
            'address_text' => 'required|string',
            'core_expertise' => 'required|string',
            'summary' => 'required|string',
            'type_id' => 'required|numeric',
            'classification_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $video = '';
        if ($request->hasFile('video')) {
            $slug = 'jobs';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'video')->first();
            $video = (new File($request, $slug, $row, $row->details))->handle();
        }

        $data = new Job();
        $data->title = $request->get('title');
        $data->short_description = $request->get('short_description');
        $data->address_text = $request->get('address_text');
        $data->core_expertise = $request->get('core_expertise');
        $data->summary = $request->get('summary');
        $data->type_id = $request->get('type_id');
        $data->classification_id = $request->get('classification_id');
        $data->provider_id = auth('sanctum')->user()->id;
        $data->video = $video;
        if ($request->has('lat') && $request->has('lng')) {
            $data->location = \DB::raw("ST_GeomFromText('POINT({$request->get('lng')}{$request->get('lat')})')");
        }
        $data->save();

        return parent::sendSuccess(trans('messages.Data Saved!'), $data ? \App\Resources\Blog::make($data) : null);
    }

    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $data = Job::where('id', $request->get('id'))->first();
        $from_type = getUserType();
        $provider_id = auth('sanctum')->user()->id;
        if ($from_type == 'provider' && $provider_id == $data->provider_id) {
            Job::where('id', $request->get('id'))->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        }

        return parent::sendSuccess(trans('messages.Error in sent Data!'), null);
    }

    public function like(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'job_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;
        $data = JobsLike::where([
            'user_id' => $user_id,
            'user_type' => $from_type,
            'job_id' => $request->get('job_id'),
        ])->first();
        if ($data) {
            $data->delete();
            return parent::sendSuccess(trans('messages.Data Saved!'), null);
        } else {
            $data = new JobsLike();
            $data->user_id = $user_id;
            $data->user_type = $from_type;
            $data->job_id = $request->get('job_id');
            $data->save();
            return parent::sendSuccess(trans('messages.Data Saved!'), null);
        }
    }
}
