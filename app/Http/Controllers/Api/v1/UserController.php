<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Message;
use App\Models\PasswordReset;
use App\Models\PhoneCodeVerify;
use App\Models\PlatformSubSubCategory;
use App\Models\PlatformUserInput;
use App\Models\Provider;
use App\Models\ProviderSpeciality;
use App\Models\ProviderSpecialityGroup;
use App\Models\User;
use App\Models\UserFollow;
use App\Models\UsersField;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Notification;
use Storage;

class UserController extends Controller
{
    public function forgetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }



            $user = Provider::
            where('phone', $request->phone)->
            orWhere('user_name', $request->phone)->
            orWhere('email', $request->phone)->
            first();

            if (!$user) {
                return parent::sendError([['message' => trans('messages.incorrect phone')]], 403);
            }


        PasswordReset::where([
            'phone' => $request->phone
        ])->delete();

        $token = generateRandomCode();
        $pr = new PasswordReset();
        $pr->phone = $request->phone;
        $pr->code = $token;
        $pr->created_at = Carbon::now()->toDateTimeString();
        $pr->save();

        try {
            Mail::send('emails.password-reset', ['token' => $token,'user'=>$user], function($message) use($user) {
                $message->to($user->email, 'Mena')->subject
                   ('Password Reset Code');
                $message->from('security@menaai.ae','Mena');
             });
            // Mail::to($user->email)->send(new \App\Mail\PasswordResetMail($token));
        } catch (\Exception $ex) {
            return $ex;
        }

        return parent::sendSuccess(trans('messages.Check your phone!'), null);

    }
    public function forgetVerifyCode(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'code' => 'required|string',
        ]);

        $pr = PasswordReset::where([
            'phone' => $request->email,
            'code' => $request->code
        ])->first();

        if ($pr) {
            return parent::sendSuccess(trans('messages.Code Is Correct!'), null);
        } else {
            return parent::sendError([['message' => trans('messages.Error in the token sent')]], 403);
        }
    }
    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'code' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }



        $user = Provider::
        where('phone', $request->email)->
        orWhere('user_name', $request->email)->
        orWhere('email', $request->email)->
        first();

        if (!$user) {
            return parent::sendError([['message' => trans('messages.incorrect phone')]], 403);
        }


        $pr = PasswordReset::where([
            'phone' => $request->email,
            'code' => $request->code
        ])->first();

        if ($pr) {
            $pr->delete();
            $user->password = bcrypt($request->password);
            $user->update();
            try {
                Mail::send('emails.password-confirmation', ['user'=>$user], function($message) use($user) {
                    $message->to($user->email, 'Mena')->subject
                       ('Password Reset Confirmation');
                    $message->from('no-reply@menaai.ae','Mena');
                 });
                // Mail::to($user->email)->send(new \App\Mail\PasswordResetMail($token));
            } catch (\Exception $ex) {
                return $ex;
            }

            return parent::sendSuccess(trans('messages.Password Reset Successfully!'), null);
        }
        else{
            return parent::sendError([['message' => trans('messages.Error in the token sent')]], 403);
        }
    }

    public function checkUserName(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $user = Provider::where('user_name',$request->user_name)->first();

        if($user){
            $usernames = [];
            for($i = 0 ; $i < 5 ; $i++){
                $newUsername = $this->checkNameExistance($request->user_name);

                array_push($usernames,$newUsername);
            }
            return parent::sendSuccess("User Name Is Not Available!",['usernmames' => $usernames],205);
        }
        else{

            return parent::sendSuccess("User Name Is Available!",['usernmames' => []]);
        }

    }
    public function checkNameExistance($originalname){
        $newUsername = $originalname.rand(10, 99);
        $user = Provider::where('user_name',$newUsername)->first();
        if($user){
            $this->checkNameExistance($originalname);
        }

        return $newUsername;
    }
    public function info(Request $request)
    {

            $user = Provider::
            orWhere('email', auth('sanctum')->user()->email)->
            first();
            if($user){

                        $user = \App\Resources\ProviderBref::make($user);

                        $fields = \App\Resources\PlatformUserInput::collection(PlatformUserInput::where('platform_id',
                        auth('sanctum')->user()->platform_id)->
                        whereIn('spciality_id', ProviderSpeciality::where('provider_id', $user->id)->pluck('platform_sub_sub_category_id'))->get());
                    $data_completed = checkUserDataCompleted($fields, $user);

                return parent::sendSuccess(trans('messages.Data Got!'), [
                    'user' => $user,
                    'platform_fields' => $fields,
                    'data_percent' => checkUserDataCompletedPercent($fields, $user),
                    'data_completed' => $data_completed
                ]);
            }
            else{
                return parent::sendError('The user is not In our records', 403);
            }
    }


    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $this->sendSMSCode($request->phone);

        return parent::sendSuccess(trans('messages.Code Sent!'), null);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $phone_verify = PhoneCodeVerify::where([
            'phone' => $request->email,
            'code' => $request->code
        ])->first();

        if ($phone_verify) {
            $phone_verify->delete();

                $user = Provider::
                where('phone', $request->email)->
                orWhere('user_name', $request->email)->
                orWhere('email', $request->email)->
                first();

            if ($user) {
                $user->phone_verified_at = Carbon::now()->toDateTimeString();
                $user->phone_verified = 1;
                $user->update();
                $email = $user->email;
                Mail::send('emails.EmailConfirm', ['user'=>$user], function($message) use($email,$user) {
                    $message->to($email, 'Mena')->subject
                        ('Welcome Email');
                    $message->from('no-reply@menaai.ae','Mena');
                });
            }
            return parent::sendSuccess(trans('messages.Correct Code!'), null);
        } else {
            return parent::sendError([['message' => trans('messages.Code Not Correct!')]], 403);
        }

    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'user_name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'nullable|string',
            'password' => 'required|string',
            'platform_id' => 'nullable|numeric|exists:platforms,id'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $user_type = 'user_type';
            // ($request->has('user_type') && strlen($request->has('user_type')) > 0) ?
            //     $request->get('user_type') : 'client';

        if ($user_type == 'client') {
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|string|unique:clients,user_name',
                'email' => 'required|string|unique:clients,email',
                'phone' => 'nullable|string|unique:clients,phone',
            ]);

            if ($validator->fails()) {
                return parent::sendError(parent::error_processor($validator), 403);
            }
            $user = new Client();
            $user->full_name = $request->full_name;
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->platform_id = $request->platform_id;
            $user->password = bcrypt($request->password);
            $user->save();

            $token = $user->createToken('apiToken')->plainTextToken;
            $user = Client::where('id', $user->id)->first();

            $this->sendSMSCode($request->phone);
            $fields = [];
            $user = \App\Resources\Client::make($user);
            $data_completed = checkUserDataCompleted($fields, $user);
        } else {
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|string|unique:providers,user_name',
                'email' => 'required|string|unique:providers,email',
                'phone' => 'nullable|string|unique:providers,phone',
                'specialities' => 'required|json',
            ]);

            if ($validator->fails()) {
                return parent::sendError(parent::error_processor($validator), 403);
            }

            $user_dashboard = new User();
            $user_dashboard->role_id = getRoleID('provider');
            $user_dashboard->full_name = $request->full_name;
            $user_dashboard->email = $request->email;
            $user_dashboard->phone = $request->phone;
            $user_dashboard->platform_id = $request->platform_id;
            $user_dashboard->password = bcrypt($request->password);
            $user_dashboard->status = 1;
            $user_dashboard->save();


            $user = new Provider();
            $user->full_name = $request->full_name;
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->platform_id = $request->platform_id;
            $user->user_id = $user_dashboard->id;
            $user->password = bcrypt($request->password);
            $user->save();


            $specialities = json_decode($request->specialities);
            if (is_array($specialities)) {
                foreach ($specialities as $spe) {
                    $ps = new ProviderSpeciality();
                    $ps->provider_id = $user->id;
                    $ps->platform_sub_sub_category_id = $spe;
                    $ps->save();
                }
            }

            $sub_categories = PlatformSubSubCategory::distinct()->where('id', $request->specialities)->pluck('sub_category_id');
            if (is_array($sub_categories)) {
                foreach ($sub_categories as $spe) {
                    $ps = new ProviderSpecialityGroup();
                    $ps->provider_id = $user->id;
                    $ps->platform_sub_category_id = $spe;
                    $ps->save();
                }
            }

            $token = $user->createToken('apiToken')->plainTextToken;
            $user = Provider::where('id', $user->id)->first();

            // $this->sendSMSCode($request->phone);
            $this->sendCodes($request->email,$user);

            $fields = \App\Resources\PlatformUserInput::collection(PlatformUserInput::where('platform_id', $user->platform_id)->
            whereIn('spciality_id', ProviderSpeciality::where('provider_id', $user->id)->pluck('platform_sub_sub_category_id'))->get());

            $user = \App\Resources\ProviderBref::make($user);
            $data_completed = checkUserDataCompleted($fields, $user);
        }


        return parent::sendSuccess(trans('messages.Data Got!'), [
            'token' => $token,
            'user' => $user,
            'platform_fields' => $fields,
            'data_percent' => checkUserDataCompletedPercent($fields, $user),
            'data_completed' => $data_completed
        ]);
    }

    public function sendCodes($email,$user = null){
        $code = generateRandomCode();
        $phone_code = new PhoneCodeVerify();
        $phone_code->phone = $email;
        $phone_code->code = $code;
        $phone_code->save();

        if($user){
            Mail::send('emails.EmailVerify', ['token' => $code,'user'=>$user], function($message) use($email,$user) {
                $message->to($email, 'Mena')->subject
                ('Verify your email address');
                $message->from('security@menaai.ae','Mena');
            });
        }

        return parent::sendSuccess(trans('messages.Check your email!'), []);
    }


    public function sendSMSCode($phone)
    {
        $phone_code = new PhoneCodeVerify();
        $phone_code->phone = $phone;
        $phone_code->code = generateRandomCode();
        $phone_code->save();
    }

    public function updatePlatformFields(Request $request)
    {
        $platform_id = auth('sanctum')->user()->platform_id;

        $fields = PlatformUserInput::where('platform_id', $platform_id)->
        whereIn('spciality_id', ProviderSpeciality::where('provider_id', auth('sanctum')->user()->id)->
        pluck('platform_sub_sub_category_id'))->get();

        $input = $request->all();

        $validations = [];
        foreach ($fields as $field) {

            $rules = ($field->required == 1 ? 'required' : 'nullable') . '|' . ($field->type);
            if ($field->type == 'file') {
                if (sizeof($field->extensions) > 0) {
                    $rules .= '|mimes:';
                }
                foreach ($field->extensions as $ex) {
                    $rules .= $ex->name . ',';
                }
                $rules = substr($rules, 0, strlen($rules) - 1);
            }
            $validations[$field->id . '_input'] = $rules;
        }


        $validator = Validator::make($request->all(), $validations);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        foreach ($fields as $field) {
            $value = NULL;
            if ($request->has($field->id . '_input')) {
                if ($field->type == 'string' || $field->type == 'numeric') {
                    $value = $request->get($field->id . '_input');
                } elseif ($field->type == 'file') {
                    if ($request->hasFile($field->id . '_input')) {
                        $value = upload('users/fields/', $request->file($field->id . '_input')->extension(), $request->file($field->id . '_input'));
                    }
                }
            }

            $uf = UsersField::where([
                'field_id' => $field->id,
                'user_id' => auth('sanctum')->user()->id
            ])->first();
            $new = false;
            if (is_null($uf)) {
                $uf = new UsersField();
                $new = true;
            } else {
                if ($field->type == 'file' && is_string($uf->value)) {
                    Storage::disk('public')->delete($uf->value);
                }
            }
            $uf->field_id = $field->id;
            $uf->user_id = auth('sanctum')->user()->id;
            $uf->value = $value;
            if ($new) {
                $uf->save();
            } else {
                $uf->update();
            }
        }

        $fields = \App\Resources\PlatformUserInput::collection($fields);

        return parent::sendSuccess(trans('messages.Data Updated!'), [
            'platform_fields' => $fields,
            'data_percent' => checkUserDataCompletedPercent($fields, auth('sanctum')->user()),
            'data_completed' => checkUserDataCompleted($fields, auth('sanctum')->user())
        ]);
    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        if ($request->email) {
            $user = User::where('email', $request->email)->where('id', '<>', auth('sanctum')->user()->id)->first();
            if ($user) {
                return parent::sendError([['message' => trans('messages.email used before!')]], 403);
            }
        }

        if ($request->phone) {
            $user = User::where('phone', $request->phone)->where('id', '<>', auth('sanctum')->user()->id)->first();
            if ($user) {
                return parent::sendError([['message' => trans('messages.phone used before!')]], 403);
            }
        }

        //        $personal_picture = 'users/default.png';
        //        if ($request->hasFile('personal_picture')) {
        //            $slug = 'users';
        //            $data_type = DataType::where('slug', $slug)->first();
        //            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'personal_picture')->first();
        //            $personal_picture = (new ContentImage($request, $slug, $row, $row->details))->handle();
        //        }

        $user = json_decode(auth('sanctum')->user());

        $user->full_name = $request->has('full_name') ? $request->get('full_name') : $user->full_name;
        $user->email = $request->has('email') ? $request->get('email') : $user->email;
        if ($request->get('email')) {
            $user->email_verified_at = NULL;
        }
        $user->phone = $request->has('phone') ? $request->get('phone') : $user->phone;
        if ($request->get('phone')) {
            $user->phone_verified_at = NULL;
            $user->phone_verified = 0;
        }
        $user->password = $request->has('password') ? bcrypt($request->password) : $user->password;
        $user->update();

        return parent::sendSuccess(trans('messages.Data Updated!'), [
            'user' => \App\Resources\User::make($user)
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }



        $user = Provider::
        where('phone', $request->email)->
        orWhere('user_name', $request->email)->
        orWhere('email', $request->email)->
        first();
        $user_type = 'provider';

        if (!$user || ($user && !Hash::check($request->password, $user->password))) {
            return parent::sendError([['message' => trans('messages.incorrect username or password')]], 403);
        }

        if (is_null($user->phone_verified_at)) {
            $this->sendSMSCode($user->phone);
        }

        if ($user_type == 'client') {
            $user = \App\Resources\Client::make($user);
            $fields = [];
            $data_completed = checkUserDataCompleted($fields, $user);
        } else {
            $user = \App\Resources\ProviderBref::make($user);

            $fields = \App\Resources\PlatformUserInput::collection(PlatformUserInput::where('platform_id', $user->platform_id)->
            whereIn('spciality_id', ProviderSpeciality::where('provider_id', $user->id)->pluck('platform_sub_sub_category_id'))->get());
            $data_completed = checkUserDataCompleted($fields, $user);
        }

        $token = $user->createToken('apiToken')->plainTextToken;
        return parent::sendSuccess(trans('messages.Logged In!'), [
            'token' => $token,
            'user' => $user,
            'platform_fields' => $fields,
            'data_percent' => checkUserDataCompletedPercent($fields, $user),
            'data_completed' => $data_completed
        ]);
    }


    public function delete(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();
        User::where('id', auth('sanctum')->user()->id)->delete();
        return parent::sendSuccess(trans('messages.Data Deleted!'), null);
    }

    public function logout(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();
        return parent::sendSuccess(trans('messages.User logged out'), null);
    }

    public function counters(Request $request)
    {
        return parent::sendSuccess(trans('messages.User logged out'),
            [
                'notifications' => \App\Models\Notification::where('notifiable_id',auth('sanctum')->user()->id)->where('read_at',NULL)->count(),
                'messages' => \App\Models\Message::where('to_id',auth('sanctum')->user()->id)->where('read_at',NULL)->count(),
            ]);
    }

    public function test(Request $request)
    {
        return auth('sanctum')->user();
    }

    public function follow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'user_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $from_type = getUserType();
        $user_id = auth('sanctum')->user()->id;
        $data = UserFollow::where([
            'user_id' => $user_id,
            'user_type' => $from_type,
            'followed_id' => $request->get('user_id'),
            'followed_type' => $request->get('user_type'),
        ])->first();
        if ($data) {
            $data->delete();
            return parent::sendSuccess(trans('messages.Data Saved!'), null);
        } else {
            $data = new UserFollow();
            $data->user_id = $user_id;
            $data->user_type = $from_type;
            $data->followed_id = $request->get('user_id');
            $data->followed_type = $request->get('user_type');
            $data->save();
            return parent::sendSuccess(trans('messages.Data Saved!'), null);
        }
    }

    public function all($type, Request $request)
    {
        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        if ($type == 'provider') {
            $data = Provider::where('status', 1);
            if ($request->has('search') && strlen($request->get('search')) > 0) {
                $data = $data->where('full_name', 'like', '%' . $request->get('search') . '%');
            }
            $data = $data->orderBy('full_name', 'asc')->paginate($limit, ['*'], 'page', $offset);
            $total_size = $data->total();
            $users_data = \App\Resources\ProviderBref::collection($data->all());
        } elseif ($type == 'client') {
            $data = Client::where('status', 1);
            if ($request->has('search') && strlen($request->get('search')) > 0) {
                $data = $data->where('full_name', 'like', '%' . $request->get('search') . '%');
            }
            $data = $data->orderBy('full_name', 'asc')->paginate($limit, ['*'], 'page', $offset);
            $total_size = $data->total();
            $users_data = \App\Resources\Client::collection($data->all());
        } else {
            $total_size = 0;
            $users_data = [];
        }


        $data = [
            'total_size' => $total_size,
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => $users_data
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }
}
