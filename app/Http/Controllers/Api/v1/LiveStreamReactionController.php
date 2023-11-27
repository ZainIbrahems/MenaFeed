<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Livestream;
use App\Models\LiveStreamReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\LiveStreamService;

class LiveStreamReactionController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'livestream_id' => 'required|numeric|exists:livestreams,id',
            'type' => 'required|in:0,1',
        ]);

        if(LiveStreamReaction::where('user_id', auth('sanctum')->id())->where('livestream_id', $request->get('livestream_id'))->first()){
            return parent::sendError(parent::error_processor($validator), 400);
        }else{
            LiveStreamReaction::create([
                'user_id' => auth('sanctum')->id(),
                'livestream_id' => $request->livestream_id,
                'type' => $request->type
            ]);

            event(new \App\Events\LiveStreamUpdated(LiveStreamService::get($request->livestream_id)));

            return parent::sendSuccess(trans('messages.Data Saved!'), []);
        }
    }

    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'livestream_id' => 'required|numeric|exists:livestreams,id',
        ]);

        $reaction = LiveStreamReaction::where('livestream_id', $request->livestream_id)->where('user_id', auth('sanctum')->id())->first();
        if($reaction){
            $reaction->delete();
            event(new \App\Events\LiveStreamUpdated(LiveStreamService::get($request->livestream_id)));
        }else{
            return parent::sendError([['message' => 'not found']], 404);
        }

        return parent::sendSuccess(trans('messages.Data Saved!'), []);
    }
}
