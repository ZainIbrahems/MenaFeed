<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LiveStreamComment;
use App\Services\LiveStreamService;
use Illuminate\Support\Facades\Validator;

class LiveStreamCommentController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'livestream_id' => 'required|numeric|exists:livestreams,id',
            'comment' => 'required|string',
        ]);

        if($validator->fails()) return parent::sendError(parent::error_processor($validator), 400);

        LiveStreamComment::create([
            'user_id' => auth('sanctum')->id(),
            'livestream_id' => $request->livestream_id,
            'comment' => $request->comment
        ]);

        event(new \App\Events\LiveStreamUpdated(LiveStreamService::get($request->livestream_id)));

        return parent::sendSuccess(trans('messages.Data Saved!'), []);
    }

    public function destroy(Request $request){
        $live_stream_comment = LiveStreamComment::find($request->comment_id);

        if(!$live_stream_comment) return parent::sendError([['message' => 'not found']], 404);

        if($live_stream_comment->user_id == auth('sanctum')->id()){
            $live_stream_comment->delete();
            event(new \App\Events\LiveStreamUpdated(LiveStreamService::get($request->livestream_id)));

            return parent::sendSuccess(trans('messages.Data Saved!'), []);
        }else{
            return parent::sendError([['message' => 'unauthorized']], 401); 
        }
    }
}
