<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProviderFeed;
use App\Models\ProviderFeedComment;
use App\Models\ProviderFeedCommentLike;
use App\Models\ProviderFeedLike;
use App\Models\ProviderFeedReport;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\ContentTypes\MultipleImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Validator;

class FeedController extends Controller
{
    public function withVideos(Request $request)
    {
        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;


        $data = ProviderFeed::query();

        $data = $data->whereJsonContains('file', ['type' => 'video']);

        $data = $data->
        has('provider')->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\ProviderFeedVideo::collection($data->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function get(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;


        $user_id = auth('sanctum')->user()->id;

        $data = ProviderFeed::where('provider_id', $user_id);

        $data = $data->has('provider')->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\ProviderFeed::collection($data->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getAll(Request $request)
    {
        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $data = ProviderFeed::has('provider');

        if ($request->has('provider_id')) {
            $data = $data->where('provider_id', $request->get('provider_id'));
        }
        
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            $from_type = getUserType();
            if($from_type == 'provider'){
                $data->whereIn('audience', ['providers', 'public', 'everyone'])->orWhere('provider_id', $user_id);
            }else{
               $data->whereIn('audience', ['public', 'everyone']); 
            }
        }else{
            $data->whereIn('audience', ['public', 'everyone']);
        }

        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\ProviderFeed::collection($data->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function send(Request $request)
    {

        $user_id = auth('sanctum')->user()->id;

        $data = new ProviderFeed();

        $data->text = $request->has('text') ? $request->get('text') : '';
        $data->audience = $request->has('audience') ? $request->get('audience') : 'only_me';
        $data->lat = $request->has('lat') ? $request->get('lat') : NULL;
        $data->lng = $request->has('lng') ? $request->get('lng') : NULL;

        $file = 'files';
        $files = [];
        if ($request->hasFile($file)) {
            foreach ($request->file($file) as $f) {
                $extenstion = strtolower($f->getClientOriginalExtension());
                $fileName = $user_id . '-' . rand(0000, 9999) . '.' . $extenstion;
                $path = "feeds/" . date('Y') . "-" . date('m') . "-" . date('d');
                $filePath = $f->storeAs($path, $fileName, 'public');
                if (in_array($extenstion, ['png', 'jpeg', 'jpg', 'gif', 'webp'])) {
                    $type = 'image';
                } elseif (in_array($extenstion, ['mp3', 'wave', 'aac'])) {
                    $type = 'audio';
                } elseif (in_array($extenstion, ['gif'])) {
                    $type = 'gif';
                } elseif (in_array($extenstion, ['mp4', 'mov', '3gp', 'avi', 'M4V', 'webm'])) {
                    $type = 'video';
                } else {
                    $type = 'file';
                }
                $files[] = [
                    'path' => $filePath,
                    'type' => $type
                ];
            }
        } else {
            $files = [];
            $type = '';
        }
        $data->file = json_encode($files);
        $data->type = '';

//        if ($data->file == NULL && strlen($data->text) == 0) {
//            return parent::sendError([['message' => trans('messages.Error in sent Data')]], 400);
//        }

        $data->provider_id = $user_id;
        $data->can_comment = 1;
        $data->save();
        return parent::sendSuccess(trans('messages.Sent!'), null);

    }

    public function update(Request $request)
    {
        $user_id = auth('sanctum')->user()->id;

        $data = ProviderFeed::where('id', $request->get('feed_id'))->where('provider_id', $user_id)->first();

        if ($request->has('text')) {
            $data->text = $request->get('text');
        }

        if ($request->has('can_comment')) {
            $data->can_comment = $request->get('can_comment');
        }

        if ($request->has('audience')) {
            $data->audience = $request->get('audience');
        }

        if ($request->has('lat')) {
            $data->lat = $request->get('lat');
        }

        if ($request->has('lng')) {
            $data->lng = $request->get('lng');
        }

        $file = 'files';
        $files = [];

        if ($request->has($file) && $request->get($file) == '[]') {
            $files = [];
        } elseif ($request->hasFile($file)) {
            foreach ($request->file($file) as $f) {
                $extenstion = strtolower($f->getClientOriginalExtension());
                $fileName = $user_id . '-' . rand(0000, 9999) . '.' . $extenstion;
                $path = "feeds/" . date('Y') . "-" . date('m') . "-" . date('d');
                $filePath = $f->storeAs($path, $fileName, 'public');
                if (in_array($extenstion, ['png', 'jpeg', 'jpg', 'gif', 'webp'])) {
                    $type = 'image';
                } elseif (in_array($extenstion, ['mp3', 'wave'])) {
                    $type = 'audio';
                } elseif (in_array($extenstion, ['gif'])) {
                    $type = 'gif';
                } elseif (in_array($extenstion, ['mp4', 'mov'])) {
                    $type = 'video';
                } elseif (in_array($extenstion, ['mp3', 'aac'])) {
                    $type = 'audio';
                } else {
                    $type = 'file';
                }
                $files[] = [
                    'path' => $filePath,
                    'type' => $type
                ];
            }

            $data->file = json_encode($files);
            $data->type = '';
        }

        $data->save();

        event(new \App\Events\FeedUpdateMessage([
            'user_id' => $data->id,
            'type' => '',
            'data' => [
                'feed' => \App\Resources\ProviderFeed::make($data)
            ]
        ]));

        return parent::sendSuccess(trans('messages.Sent!'), null);

    }

    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $user_id = auth('sanctum')->user()->id;
        $feed = ProviderFeed::where('provider_id', $user_id)->where('id', $request->get('id'))->first();

        if ($feed) {
            ProviderFeed::where('provider_id', $user_id)->where('id', $request->get('id'))->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendError([['message' => trans('messages.Error in sent Data')]], 400);
        }
    }

    public function saveComment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'feed_id' => 'required|numeric',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $feed = ProviderFeed::where('id', $request->get('feed_id'))->first();
        if ($feed->can_comment != 1) {
            return parent::sendError([['message' => trans('messages.Can not comment on this post')]], 400);
        }

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;
        $data = new ProviderFeedComment();
        $data->user_id = $user_id;
        $data->user_type = $from_type;
        $data->comment = $request->get('comment');
        $data->comment_id = $request->has('comment_id') ? $request->get('comment_id') : NULL;
        $data->feed_id = $request->get('feed_id');
        if ($data->save()) {

            event(new \App\Events\FeedUpdateMessage([
                'user_id' => $request->get('feed_id'),
                'type' => '',
                'data' => [
                    'feed' => \App\Resources\ProviderFeed::make(ProviderFeed::where('id', $request->get('feed_id'))->first())
                ]
            ]));

//            ProviderFeed::where('provider_id', $user_id)->where('id', $request->get('id'))->delete();
            return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderFeed::make(
                ProviderFeed::where('id', $request->get('feed_id'))->first())
            );
        } else {
            return parent::sendError([['message' => trans('messages.Error in sent Data')]], 400);
        }
    }

    public function deleteComment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $from_type = getUserType();
        $user_id = auth('sanctum')->user()->id;

        $comment = ProviderFeedComment::where('id', $request->get('comment_id'))->first();
        if ($comment && ($comment->user_type != $from_type || $comment->user_id != $user_id)) {
            return parent::sendError([['message' => trans('messages.Can not delete')]], 400);
        }

        if ($comment) {
            $feed = ProviderFeed::where('id', $comment->feed_id)->first();
            if (!$feed || ($feed && $from_type == 'provider' && $feed->provider_id != $user_id)) {
                return parent::sendError([['message' => trans('messages.Can not delete')]], 400);
            }
        }

        if (ProviderFeedComment::where('id', $request->get('comment_id'))
            ->where('user_type', $from_type)
            ->where('user_id', $user_id)
            ->delete()) {
            $feed = ProviderFeed::where('id', $comment->feed_id)->first();
            /*
             * delete childs
             */
            ProviderFeedComment::where('comment_id', $request->get('comment_id'))->delete();
            ProviderFeedCommentLike::where('comment_id', $request->get('comment_id'))->delete();

            event(new \App\Events\FeedUpdateMessage([
                'user_id' => $request->get('feed_id'),
                'type' => '',
                'data' => [
                    'feed' => \App\Resources\ProviderFeed::make(ProviderFeed::where('id', $comment->feed_id)->first())
                ]
            ]));

            return parent::sendSuccess(trans('messages.Data Deleted!'), \App\Resources\ProviderFeed::make(
                ProviderFeed::where('id', $feed->id)->first())
            );
        } else {
            return parent::sendError([['message' => trans('messages.Error while Data Deleted!')]], 400);
        }
    }

    public function saveReport(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'feed_id' => 'required|numeric',
            'report' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $feed = ProviderFeed::where('id', $request->get('feed_id'))->first();
        if ($feed->can_comment != 1) {
            return parent::sendError([['message' => trans('messages.Can not comment on this post')]], 400);
        }

        $images = [];
        $slug = 'provider-feeds-reports';
        if ($request->hasFile('images')) {
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'images')->first();
            $images = (new MultipleImage($request, $slug, $row, $row->details))->handle();
        }

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;
        $data = new ProviderFeedReport();
        $data->user_id = $user_id;
        $data->user_type = $from_type;
        $data->report = $request->get('report');
        $data->feed_id = $request->get('feed_id');
        if ($data->save()) {
//            ProviderFeed::where('provider_id', $user_id)->where('id', $request->get('id'))->delete();
            return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderFeed::make(
                ProviderFeed::where('id', $request->get('feed_id'))->first())
            );
        } else {
            return parent::sendError([['message' => trans('messages.Error in sent Data')]], 400);
        }
    }

    public function getComments(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;


        $data = ProviderFeedComment::where('feed_id', $request->get('feed_id'))->where('comment_id', NULL);

        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\ProviderFeedComment::collection($data->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function likeComment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;
        $data = ProviderFeedCommentLike::where([
            'user_id' => $user_id,
            'user_type' => $from_type,
            'is_like' => $request->get('is_like'),
            'comment_id' => $request->get('comment_id'),
        ])->first();
        $comment = ProviderFeedComment::where('id', $request->get('comment_id'))->first();
        if ($data) {
            $data->delete();
            $com = \App\Resources\ProviderFeedComment::make(ProviderFeedComment::where('id', $request->get('comment_id'))->first());
            event(new \App\Events\FeedUpdateMessage([
                'user_id' => $request->get('feed_id'),
                'type' => '',
                'data' => [
                    'feed' => \App\Resources\ProviderFeed::make(ProviderFeed::where('id', $comment->feed_id)->first())
                ]
            ]));
            return parent::sendSuccess(trans('messages.Data Saved!'), $com);
        } else {
            $data = new ProviderFeedCommentLike();
            $data->user_id = $user_id;
            $data->user_type = $from_type;
            $data->is_like = $request->get('is_like');
            $data->comment_id = $request->get('comment_id');
            $data->save();
            ProviderFeedCommentLike::where([
                'user_id' => $user_id,
                'user_type' => $from_type,
                'is_like' => abs($request->get('is_like') - 1),
                'comment_id' => $request->get('comment_id'),
            ])->delete();
            $com = \App\Resources\ProviderFeedComment::make(ProviderFeedComment::where('id', $request->get('comment_id'))->first());

            event(new \App\Events\FeedUpdateMessage([
                'user_id' => $request->get('feed_id'),
                'type' => '',
                'data' => [
                    'feed' => \App\Resources\ProviderFeed::make(ProviderFeed::where('id', $comment->feed_id)->first())
                ]
            ]));

            return parent::sendSuccess(trans('messages.Data Saved!'), $com);
        }
    }

    public function like(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'feed_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;
        $data = ProviderFeedLike::where([
            'user_id' => $user_id,
            'user_type' => $from_type,
            'feed_id' => $request->get('feed_id'),
        ])->first();
        if ($data) {
            $data->delete();

        } else {
            $data = new ProviderFeedLike();
            $data->user_id = $user_id;
            $data->user_type = $from_type;
            $data->feed_id = $request->get('feed_id');
            $data->save();
        }


        event(new \App\Events\FeedUpdateMessage([
            'user_id' => $request->get('feed_id'),
            'type' => '',
            'data' => [
                'feed' => \App\Resources\ProviderFeed::make(ProviderFeed::where('id', $request->get('feed_id'))->first())
            ]
        ]));

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }
}
