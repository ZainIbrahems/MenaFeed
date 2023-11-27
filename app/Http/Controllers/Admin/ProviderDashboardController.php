<?php

namespace App\Http\Controllers\Admin;

use App\Mail\LiveInvitation;
use App\Models\Live;
use App\Models\Livestream;
use App\Models\Provider;
use App\Models\ProviderLivestream;
use App\Models\ProviderSpeciality;
use App\Models\ProviderSpecialityGroup;
use App\Models\ProvidersProfessional;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;
use stdClass;
use TCG\Voyager\Http\Controllers\ContentTypes\File;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Validator;

class ProviderDashboardController extends VoyagerBaseController
{
    function live(Request $request, $id)
    {
        $live = Live::where('code', $id)->first();
        if (!$live) {
            return redirect()->back()->with([
                'message' => 'The meeting does not exist',
                'alert-type' => 'error',
            ]);
        }

        $meeting = new \stdClass();
        $planType = 'free';
        $is_webview = false;
        if (getSetting('AUTH_MODE')->options === 'enabled') {
            $meeting = Live::where(['code' => $id])->first();

            if (!$meeting) {
                return redirect()->back()->with([
                    'message' => 'The meeting does not exist',
                    'alert-type' => 'error',
                ]);
            }

            if (auth('web')->check()) {
                $planType = auth('web')->user()->plan_type;
            }
        } else {
            $planType = 'free';
            $meeting->title = 'Live';
            $meeting->meeting_id = $id;
            $meeting->description = '-';
            $meeting->password = null;
            $meeting->user_id = 0;
        }

        if (auth()->check()) {
            $role = auth('web')->user()->role_id;
            if ($role == getRoleID('admin') || $role == getRoleID('nm-admin') || $role == getRoleID('super-admin')) {
                $meeting->isModerator = true;
            } elseif (auth()->user()->role_id == getRoleID('provider')) {
                $provider = Provider::where('user_id', auth('web')->user()->id)->first();
                if ($provider && $meeting->added_by == $provider->id) {
                    $meeting->isModerator = true;
                }
            }
            $user = auth()->user();
        } else {

            if (request()->has('Authorization')) {

                $user = cUrlGetData(
                    route('get_user_data'),
                    [],
                    [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Authorization: Bearer ' . request()->input('Authorization')
                    ]
                );
                $is_webview = true;
                $user = json_decode($user, true);
            } else {
                $meeting->isModerator = true;
                $user = null;
            }

        }

        $meeting->limitedTimeMeeting = false;
        $meeting->username = Auth::user() ? Auth::user()->name . ($meeting->isModerator ? ' (Moderator)' : '') : '';

        return view('live.custom-live', [
            'page' => 'Meeting',
            'lecture' => $live,
            'meeting' => $meeting,
            'is_webview' => $is_webview,
            'Authorization' => request()->has('Authorization') ? request()->get('Authorization') : -1,
            'user' => $user,
        ]);
    }

    public function sendInvite(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $meeting = Live::find($request->id);
        $added_new = false;
        if (!str_contains($meeting, $request->email)) {
            $added_new = true;
            $meeting->invites .= $meeting->invites ? ',' . $request->email : $request->email;
        }
        if ($meeting->save()) {
            try {
                Mail::to($request->email)->send(new LiveInvitation($meeting));
            } catch (\Exception $ex) {
            }
            if ($added_new) {
                return json_encode(['success' => true, 'new' => true]);
            } else {
                return json_encode(['success' => true, 'new' => false]);
            }
        }

        return json_encode(['success' => false]);
    }

    //get all the invites associated with the meeting
    public function getInvites(Request $request)
    {
        $meeting = Live::find($request->id);

        if ($meeting) {
            return json_encode(['success' => true, 'data' => $meeting->invites ? explode(',', $meeting->invites) : []]);
        }

        return json_encode(['success' => true]);
    }

    //check if the meeting exist
    public function checkLive(Request $request)
    {
        if (getSetting('AUTH_MODE')->options == 'disabled') {
            return json_encode(['success' => true, 'id' => $request->id]);
        }

        $meeting = Live::where(['code' => $request->id, 'status' => 'active'])->first();

        if ($meeting) {
            return json_encode(['success' => true, 'id' => $request->id]);
        }

        return json_encode(['success' => false]);
    }

    public function checkLivePassword(Request $request)
    {

        return json_encode(['success' => true]);
    }

    public function getLiveDetails()
    {
        $details = new stdClass();
        $details->timeLimit = getSetting('TIME_LIMIT')->text;
        $details->stunUrl = getSetting('STUN_URL')->text;
        $details->turnUrl = getSetting('TURN_URL')->text;
        $details->turnUsername = getSetting('TURN_USERNAME')->text;
        $details->turnPassword = getSetting('TURN_PASSWORD')->text;
        $details->defaultUsername = getSetting('DEFAULT_USERNAME')->text;
        $details->appName = getSetting('APPLICATION_NAME')->text;
        $details->signalingURL = getSetting('SIGNALING_URL')->text;
        $details->authMode = getSetting('AUTH_MODE')->options;
        $details->moderatorRights = getSetting('MODERATOR_RIGHTS')->options;

        return json_encode(['success' => true, 'data' => $details]);
    }

    function deleteProfessional(Request $request)
    {

        ProvidersProfessional::where([
            'provider_id' => $request->get('provider_id'),
            'professional_id' => $request->get('id')
        ])->delete();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);
    }

    function addProfessional(Request $request)
    {
        if ($request->get('type') == 'old') {
            $professionals = $request->get('professionals');
            foreach ($professionals as $professional) {
                $pp = ProvidersProfessional::where([
                    'provider_id' => $request->get('provider_id'),
                    'professional_id' => $professional
                ])->first();
                if (!$pp) {
                    $pp = new ProvidersProfessional();
                    $pp->provider_id = $request->get('provider_id');
                    $pp->professional_id = $professional;
                    $pp->save();
                }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string',
                'email' => 'required|email|unique:providers,email',
                'phone' => 'required|string|unique:providers,phone',
                'qualification_certificate' => 'required',
                'professional_license' => 'required',
            ]);

            if ($validator->fails()) {
                $messages = $validator->messages();
                return redirect()->back()->withErrors($messages);
            }

            $prv = new Provider();
            $prv->email = $request->get('email');
            $prv->phone = $request->get('phone');
            $prv->full_name = $request->get('full_name');
            $prv->added_by = $request->get('provider_id');
            $prv->platform_category = $request->get('platform_category');
//            $prv->speciality_group = $request->get('speciality_group');

            if ($request->hasFile('qualification_certificate')) {
                $slug = 'providers';
                $data_type = DataType::where('slug', $slug)->first();
                $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'qualification_certificate')->first();
                $prv->qualification_certificate = (new File($request, $slug, $row, $row->details))->handle();
            }


            if ($request->hasFile('professional_license')) {
                $slug = 'providers';
                $data_type = DataType::where('slug', $slug)->first();
                $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'professional_license')->first();
                $prv->professional_license = (new File($request, $slug, $row, $row->details))->handle();
            }

            $prv->save();

            if (is_array($request->get('specialities'))) {
                foreach ($request->get('specialities') as $sp) {
                    $ps = new ProviderSpeciality();
                    $ps->provider_id = $prv->id;
                    $ps->platform_sub_sub_category_id = $sp;
                    $ps->save();
                }
            }


            $pp = new ProvidersProfessional();
            $pp->provider_id = $request->get('provider_id');
            $pp->professional_id = $prv->id;
            $pp->save();

        }

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);
    }


    function saveAccountDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'password' => 'nullable|string|confirmed',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()->withErrors($messages);
        }

        $provider = Provider::where('id', $request->get('provider_id'))->first();

        if ($request->hasFile('personal_picture')) {
            $slug = 'providers';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'personal_picture')->first();
            $provider->personal_picture = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }

        $provider->abbreviation_id = $request->get('abbreviation_id');
        $provider->full_name = $request->get('full_name');
        $provider->email = $request->get('email');
        $provider->recovery_email = $request->get('recovery_email');
        $provider->phone = $request->get('phone');
        $provider->summary = $request->get('summary');
        $provider->user_name = $request->get('user_name');
        if ($request->has('password') && strlen($request->get('password')) > 8) {
            $provider->password = bcrypt($request->get('password'));
        }
        $user = User::where('id', $provider->user_id)->first();
        if ($user) {
            if ($request->has('password') && strlen($request->get('password')) > 8) {
                $user->password = bcrypt($request->get('password'));
                $user->update();
            }
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->full_name = $request->get('full_name');
        }
        $user->update();

        $array = json_decode($request->full_name_i18n);
        updateTranslation('providers', $array, 'full_name', $provider->id);

        $array = json_decode($request->summary_i18n);
        updateTranslation('providers', $array, 'summary', $provider->id);

        $provider->update();
        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);
    }

    function saveAccountVerification(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'full_name' => 'required|string',
//            'email' => 'required|email',
//            'phone' => 'nullable|string',
//            'password' => 'nullable|string|confirmed',
//        ]);
//
//        if ($validator->fails()) {
//            $messages = $validator->messages();
//            return redirect()->back()->withErrors($messages);
//        }
//

        $provider = Provider::where('id', $request->get('provider_id'))->first();


        $provider->provider_type_id = $request->get('provider_type_id');
        $provider->registration_number = $request->get('registration_number');
        $provider->platform_id = $request->get('platform_id');
        $provider->platform_category = $request->get('platform_category');
        $provider->address = $request->get('address2');

        if ($request->hasFile('qualification_certificate')) {
            $slug = 'providers';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'qualification_certificate')->first();
            $provider->qualification_certificate = (new File($request, $slug, $row, $row->details))->handle();
        }


        if ($request->hasFile('professional_license')) {
            $slug = 'providers';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'professional_license')->first();
            $provider->professional_license = (new File($request, $slug, $row, $row->details))->handle();
        }

        ProviderSpecialityGroup::where('provider_id', $provider->id)->delete();
        if (is_array($request->get('speciality_group'))) {
            foreach ($request->get('speciality_group') as $sp) {
                $ps = new ProviderSpecialityGroup();
                $ps->provider_id = $provider->id;
                $ps->platform_sub_category_id = $sp;
                $ps->save();
            }
        }

        ProviderSpeciality::where('provider_id', $provider->id)->delete();
        if (is_array($request->get('specialities'))) {
            foreach ($request->get('specialities') as $sp) {
                $ps = new ProviderSpeciality();
                $ps->provider_id = $provider->id;
                $ps->platform_sub_sub_category_id = $sp;
                $ps->save();
            }
        }

        if ($request->has('platform_id')) {
            $user = User::where('id', $provider->user_id)->first();
            if ($user) {
                $user->platform_id = $request->get('platform_id');
                $user->update();
            }
        }

        if ($request->has('location')) {
            $location = $request->get('location');
            $provider->location = DB::raw("ST_GeomFromText('POINT({$location['lng']} {$location['lat']})')");
        }


        $provider->update();
        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);
    }

    function provider_account_details()
    {
        return view('provider.provider_account_details');
    }

    function provider_account_verification()
    {
        return view('provider.provider_account_verification');
    }

    function provider_about()
    {
        return view('provider.provider_about');
    }

    function provider_qualifications()
    {
        return view('provider.provider_qualifications');
    }

    function provider_professional_experience()
    {
        return view('provider.provider_professional_experience');
    }

    function provider_my_publications()
    {
        return view('provider.provider_my_publications');
    }

    function provider_vacation_certificates()
    {
        return view('provider.provider_vacation_certificates');
    }

    function provider_memberships()
    {
        return view('provider.provider_memberships');
    }

    function provider_awards_honors()
    {
        return view('provider.provider_awards_honors');
    }

    function provider_contact_details()
    {
        return view('provider.provider_contact_details');
    }

    function provider_social_media()
    {
        return view('provider.provider_social_media');
    }

    function provider_professionals()
    {
        return view('provider.provider_professionals');
    }

    function provider_show_professionals()
    {
        return view('provider.provider_show_professionals');
    }

    function goLive()
    {

        $validator = Validator::make(request()->all(), [
            'title' => 'required|string',
            'goal' => 'required|string',
            'topic' => 'required|string',
            'live_now_category_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        Livestream::where([
            'added_by' => auth('sanctum')->user()->id
        ])->update([
            'status' => 'stop_live'
        ]);

        $lv = new Livestream();
        $lv->live_now_category_id = request()->get('live_now_category_id');
        $lv->title = request()->get('title');
        $lv->goal = request()->get('goal');
        $lv->topic = request()->get('topic');
        $lv->date_time = Carbon::now()->toDateTimeString();
        $lv->duration = 60;
        $lv->room_id = generateRandomString(6);
        $lv->status = 'on_live';
        $lv->platform_id = auth('web')->user()->platform_id;
        $lv->added_by = auth('web')->user()->id;

        $lv->save();

        $pl = new ProviderLivestream();
        $pl->live_id = $lv->id;
        $pl->provider_id = auth('web')->user()->id;
        $pl->save();

        $provider = Provider::where('id', auth('web')->user()->id)->first();
        if ($provider) {
            $provider->is_live = 1;
            $provider->update();
        }

        return \Redirect::route('show-live', [
            'roomID' => $lv->room_id
        ]);
    }


    function showLive()
    {
        $lv = Livestream::where('room_id', request()->get('roomID'))->orderBy('id', 'desc')->first();
        if (!$lv) {
            return 'Live not found!';
        }
        return view('live.custom-live', [
            'lv' => $lv
        ]);
    }
}
