<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatsReport;
use App\Models\Message;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ChatController extends Controller
{

    public function send(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'to_id' => 'required|numeric',
            'to_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $from_type = getUserType();

        $from_id = auth('sanctum')->user()->id;
        $to_id = $request->get('to_id');
        $to_type = $request->get('to_type');

        $chat = Chat::where(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $from_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
                'to_id' => $to_id,
                'to_type' => $to_type
            ]);
        })->orWhere(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $to_id,
                'from_type' => $to_type,
                'to_deleted' => 0,
                'to_id' => $from_id,
                'to_type' => $from_type
            ]);
        })->first();


        if ($chat && $chat->is_blocked == 1) {
            return parent::sendError([['message' => trans('messages.This chat blocked!')]], 403);
        }


        if (!$chat) {
            $chat = new Chat();
            $chat->from_id = $from_id;
            $chat->from_type = $from_type;
            $chat->to_id = $to_id;
            $chat->to_type = $to_type;
            $chat->last_message = '';
            $chat->last_message_from = -1;
            $chat->save();
        }

        $user_id = auth('sanctum')->user()->id;


        $file = 'files';
        $files = [];
        $type = '';
        if ($request->hasFile($file)) {
            foreach ($request->file($file) as $f) {
                $extenstion = strtolower($f->getClientOriginalExtension());
                $fileName = $user_id . '-' . rand(0000, 9999) . '.' . $extenstion;
                $path = "chats/" . date('Y') . "-" . date('m') . "-" . date('d');
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
        } else {
            $files = [];
            $type = 'text';
        }

        $message_sent = ($request->has('message') && $request->get('message') != NULL) ? $request->get('message') : '';

        Chat::where('id', $chat->id)->update([
            'last_message' => ($request->has('message')
                && $request->get('message') != NULL) ? $request->get('message') : trans('messages.sent', ['file' => $type]),
            'last_message_from' => $from_id,
            'message_type' => $type,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        $message = new Message();
        $message->message = $message_sent;
        $message->files = json_encode($files);
        $message->type = $type;
        $message->chat_id = $chat->id;
        $message->from_id = $from_id;
        $message->to_id = $to_id;
        $message->save();

        try {
            event(new \App\Events\CountersMessage([
                'user_id' => $request->get('to_id'),
                'type' => $request->get('to_type'),
                'data' => [
                    'notifications' => \App\Models\Notification::where('notifiable_id', auth('sanctum')->user()->id)->where('read_at', NULL)->count(),
                    'messages' => \App\Models\Message::where('to_id', auth('sanctum')->user()->id)->where('read_at', NULL)->count(),
                ]
            ]));
            event(new \App\Events\CountersMessage([
                'user_id' => $from_id,
                'type' => $from_type,
                'data' => [
                    'notifications' => \App\Models\Notification::where('notifiable_id', auth('sanctum')->user()->id)->where('read_at', NULL)->count(),
                    'messages' => \App\Models\Message::where('to_id', auth('sanctum')->user()->id)->where('read_at', NULL)->count(),
                ]
            ]));
            event(new \App\Events\MessageMessage([
                'user_id' => $request->get('to_id'),
                'type' => $request->get('to_type'),
                'data' => [
                    'message' => \App\Resources\Message::make($message)
                ]
            ]));
            event(new \App\Events\NewMessageMessage([
                'user_id' => $request->get('to_id'),
                'type' => $request->get('to_type'),
                'data' => getMessagesByToID($request->get('to_id'), $request->get('to_type'), $from_id, $from_type)
            ]));
            event(new \App\Events\MessageMessage([
                'user_id' => $from_id,
                'type' => $from_type,
                'data' => [
                    'message' => \App\Resources\Message::make($message)
                ]
            ]));

        } catch (\Exception $ex) {

        }

        return parent::sendSuccess(trans('messages.Sent!'), null);

    }


    public function get(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;

        $data = Chat::
        where(function ($q) use ($user_id, $from_type) {
            return $q->where([
                'from_id' => $user_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
            ]);
        })->orWhere(function ($q) use ($user_id, $from_type) {
            return $q->where([
                'to_id' => $user_id,
                'to_type' => $from_type,
                'to_deleted' => 0,
            ]);
        });
        $data = $data->
        //        has('from')->has('to')->
        orderBy('updated_at', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\Chat::collection($data->all())
        ];


        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function online(Request $request)
    {
        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;

        $data = Chat::
        where(function ($q) use ($user_id, $from_type) {
            return $q->where([
                'from_id' => $user_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
            ]);
        })->orWhere(function ($q) use ($user_id, $from_type) {
            return $q->where([
                'to_id' => $user_id,
                'to_type' => $from_type,
                'to_deleted' => 0,
            ]);
        });
        $data = $data->
        has('from')->has('to')->orderBy('updated_at', 'desc')->paginate($limit, ['*'], 'page', $offset);


        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\ChatOnline::collection($data->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }


    public function messages(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        if ($request->has('chat_id')) {
            return parent::sendSuccess(trans('messages.Data Got!'), getMessagesByChatID($request->get('chat_id'), $limit, $offset));
        } elseif ($request->has('to_id')) {
            $to_id = $request->get('to_id');
            $to_type = $request->get('to_type');
            $from_type = getUserType();
            $from_id = auth('sanctum')->user()->id;
            return parent::sendSuccess(trans('messages.Data Got!'),
                getMessagesByToID($to_id, $to_type, $from_id, $from_type, $limit, $offset));
        }

        return parent::sendSuccess(trans('messages.Data Got!'), []);
    }

    public function getLastMessage($id)
    {
        $data = Message::where('chat_id', $id)->orderBy('id', 'desc')->first();
        if ($data) {
            $data = \App\Resources\Message::make($data);
        }
        return response()->json($data);
    }


    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $chat = Chat::where('id', $request->get('chat_id'))->first();

        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $from_type = getUserType();
        $from_id = auth('sanctum')->user()->id;
        $to_id = $chat->to_id;
        $to_type = $chat->to_type;

        $chat = Chat::where(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $from_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
                'to_id' => $to_id,
                'to_type' => $to_type
            ]);
        })->orWhere(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $to_id,
                'from_type' => $to_type,
                'to_deleted' => 0,
                'to_id' => $from_id,
                'to_type' => $from_type
            ]);
        })->first();


        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        if (auth('sanctum')->user()->id == $chat->from_id) {
            $chat->update([
                'from_deleted' => 1,
                'from_deleted_at' => Carbon::now()->toDateTimeString()
            ]);
        } else {
            $chat->update([
                'to_deleted' => 1,
                'to_deleted_at' => Carbon::now()->toDateTimeString()
            ]);
        }

        return parent::sendSuccess(trans('messages.Data Deleted!'), null);
    }

    public function markAsRead(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $chat = Chat::where('id', $request->get('chat_id'))->first();

        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $from_type = getUserType();
        $from_id = auth('sanctum')->user()->id;
        $to_id = $chat->to_id;
        $to_type = $chat->to_type;

        $chat = Chat::where(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $from_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
                'to_id' => $to_id,
                'to_type' => $to_type
            ]);
        })->orWhere(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $to_id,
                'from_type' => $to_type,
                'to_deleted' => 0,
                'to_id' => $from_id,
                'to_type' => $from_type
            ]);
        })->first();


        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        Message::where([
            'to_id' => auth('sanctum')->user()->id,
            'chat_id' => $chat->id
        ])->update([
            'read_at' => Carbon::now()->toDateTimeString()
        ]);

        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }

    public function reportToMena(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $chat = Chat::where('id', $request->get('chat_id'))->first();

        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $from_type = getUserType();
        $from_id = auth('sanctum')->user()->id;
        $to_id = $chat->to_id;
        $to_type = $chat->to_type;

        $chat = Chat::where(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $from_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
                'to_id' => $to_id,
                'to_type' => $to_type
            ]);
        })->orWhere(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $to_id,
                'from_type' => $to_type,
                'to_deleted' => 0,
                'to_id' => $from_id,
                'to_type' => $from_type
            ]);
        })->first();


        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $cr = new ChatsReport();
        $cr->report_from = auth('sanctum')->user()->id;
        $cr->report_type = $from_type;
        $cr->chat_id = $chat->id;
        $cr->save();

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }

    public function blockUserInChat(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $chat = Chat::where('id', $request->get('chat_id'))->first();

        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);;
        }

        $from_type = getUserType();
        $from_id = auth('sanctum')->user()->id;
        $to_id = $chat->to_id;
        $to_type = $chat->to_type;

        $chat = Chat::where(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $from_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
                'to_id' => $to_id,
                'to_type' => $to_type
            ]);
        })->orWhere(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $to_id,
                'from_type' => $to_type,
                'to_deleted' => 0,
                'to_id' => $from_id,
                'to_type' => $from_type
            ]);
        })->first();


        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $chat->is_blocked = 1;
        $chat->blocked_by = $from_id;
        $chat->update();

        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }

    public function clearChat(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $chat = Chat::where('id', $request->get('chat_id'))->first();

        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $from_type = getUserType();
        $from_id = auth('sanctum')->user()->id;
        $to_id = $chat->to_id;
        $to_type = $chat->to_type;

        $chat = Chat::where(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $from_id,
                'from_type' => $from_type,
                'from_deleted' => 0,
                'to_id' => $to_id,
                'to_type' => $to_type
            ]);
        })->orWhere(function ($q) use ($from_id, $from_type, $to_id, $to_type) {
            return $q->where([
                'from_id' => $to_id,
                'from_type' => $to_type,
                'to_deleted' => 0,
                'to_id' => $from_id,
                'to_type' => $from_type
            ]);
        })->first();


        if (!$chat) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }


        if (auth('sanctum')->user()->id == $chat->from_id) {
            Message::where('chat_id', $chat->id)->update([
                'from_deleted' => 1
            ]);
        } else {
            Message::where('chat_id', $chat->id)->update([
                'to_deleted' => 1
            ]);
        }

        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }


    public function myContact(Request $request)
    {
        $data_found = [];
        $data_not_found = [];
        if ($request->has('contacts')) {
            $contacts = json_decode($request->get('contacts'));
            if (is_array($contacts)) {
                foreach ($contacts as $c) {
                    $provider = Provider::where('phone', 'like', '%' . clearPhone($c) . '%')->first();
                    if ($provider) {
                        $data_found[] = [
                            'image' => getImageURL($provider->personal_picture),
                            'name' => $provider->full_name,
                            'phone' => $c,
                            'found' => true,
                        ];
                    } else {
                        $data_not_found[] = [
                            'image' => "",
                            'name' => "",
                            'phone' => $c,
                            'found' => false,
                        ];
                    }
                }
            }
        }
        return parent::sendSuccess(trans('messages.Data Got!'), array_merge($data_found, $data_not_found));
    }
}
