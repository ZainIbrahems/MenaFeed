<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\AppointmentClient;
use App\Models\AppointmentSlot;
use App\Models\AppointmentSlotDays;
use App\Models\AppointmentSlotTimes;
use App\Models\Provider;
use App\Resources\InsuranceProvider;
use App\Resources\ProviderBrefAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Validator;

class AppointmentsController extends Controller
{

    public function slotCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'days' => 'required|array',
            'time_from' => 'required|array',
            'time_to' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        if ($request->has('days') && is_array($request->get('days')) &&
            sizeof($request->get('days')) <= 0) {
            return parent::sendError([['message' =>trans('messages.Please Add Days!')]], 403);
        }

        if ($request->has('time_from') && is_array($request->get('time_from')) &&
            sizeof($request->get('time_from')) <= 0) {
            return parent::sendError([['message' =>trans('messages.Please Add Times!')]], 403);
        }

        $check = checkSlots($request->get('days'),
            $request->get('time_from'), $request->get('time_to'), $request->get('provider_id'));
        if (!$check['status']) {
            return parent::sendError([['message' =>"Some slot times not available! <br/> Day: " . $check['d'] . ' - Time From: '
                . $check['tf'] . ' - Time To: ' . $check['tt']]], 403);
        }

        $app = new AppointmentSlot();
        $app->provider_id = auth('sanctum')->user()->id;
        $app->date_time = null;
        $app->appointment_type = $request->get('appointment_type');
        $app->facility_id = (is_numeric($request->get('facility_id')) && $request->get('facility_id') > 0) ? $request->get('facility_id') : NULL;
        $app->professional_id = (is_numeric($request->get('professional_id')) && $request->get('professional_id') > 0) ? $request->get('professional_id') : NULL;
        $app->fees = $request->get('fees');
        $app->currency = $request->get('currency');
        $app->save();

        foreach ($request->get('time_from') as $key => $t) {
            $st = new AppointmentSlotTimes();
            $st->from_time = $t;
            $st->to_time = $request->get('time_to')[$key];
            $st->slot_id = $app->id;
            $st->save();
        }


        foreach ($request->get('days') as $key => $t) {
            $st = new AppointmentSlotDays();
            $st->day = $t;
            $st->slot_id = $app->id;
            $st->save();
        }

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }

    public function slotUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'days' => 'array',
            'time_from' => 'array',
            'time_to' => 'array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $app = AppointmentSlot::where('id', $request->get('slot_id'))->first();
        $app->provider_id = auth('sanctum')->user()->id;
        $app->date_time = null;
        $app->appointment_type = $request->has('appointment_type')?$request->get('appointment_type'):$app->appointment_type;
        $app->facility_id =$request->has('facility_id')? ((is_numeric($request->get('facility_id')) && $request->get('facility_id') > 0) ?
            $request->get('facility_id') : NULL):$app->facility_id;
        $app->professional_id = $request->has('professional_id')?((is_numeric($request->get('professional_id')) &&
            $request->get('professional_id') > 0) ? $request->get('professional_id') : NULL):$app->professional_id;
        $app->fees = $request->has('fees')?$request->get('fees'):$app->fees;
        $app->currency = $request->has('currency')?$request->get('currency'):$app->currency;
        $app->update();

        if ($request->has('days') && is_array($request->get('days')) &&
            sizeof($request->get('days')) > 0) {
            $check = checkSlots($request->get('days'),
                $request->get('time_from'), $request->get('time_to'), $request->get('provider_id'));
            if (!$check['status']) {
                return parent::sendError([['message' =>"Some slot times not available! <br/> Day: " . $check['d'] . ' - Time From: '
                    . $check['tf'] . ' - Time To: ' . $check['tt']]], 403);
            }
            AppointmentSlotDays::where('slot_id', $request->get('slot_id'))->delete();
            foreach ($request->get('days') as $key => $t) {
                $st = new AppointmentSlotDays();
                $st->day = $t;
                $st->slot_id = $app->id;
                $st->save();
            }
        }

        if ($request->has('time_from') && is_array($request->get('time_from')) &&
            sizeof($request->get('time_from')) > 0) {
            AppointmentSlotTimes::where('slot_id', $request->get('slot_id'))->delete();
            foreach ($request->get('time_from') as $key => $t) {
                $st = new AppointmentSlotTimes();
                $st->from_time = $t;
                $st->to_time = $request->get('time_to')[$key];
                $st->slot_id = $app->id;
                $st->save();
            }
        }

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }


    public function slotProfFac(Request $request)
    {
        $providers = Provider::select('providers.*')->distinct();

        $p = 0;
        $f = 0;
        //if professional
        if (auth('sanctum')->user()->provider_type_id == 1) {
            $f = 2;
        } //if facility
        else {
            $p = 2;
        }

        if ($request->has('name') && strlen($request->get('name')) > 0) {
            $name = $request->get('name');
            $providers = $providers->where('full_name', 'like', '%' . $name . '%');
        }

        if ($p > 0) {
            $facilities = \App\Models\ProvidersProfessional::where('provider_id',
                auth('sanctum')->user()->id)->pluck('professional_id');
            $providers = $providers->whereIn('providers.id', $facilities);
        }

        if ($f > 0) {
            $facilities = \App\Models\ProvidersProfessional::where('professional_id',
                auth('sanctum')->user()->id)->pluck('provider_id');
            $providers = $providers->whereIn('providers.id', $facilities);
        }


        $providers = $providers->get();

        return parent::sendSuccess(trans('messages.Data Got!'), [
            'type' => $p > $f ? 'professionals' : 'facilities',
            'info' => ProviderBrefAppointment::collection($providers)
        ]);
    }

    public function insurance_providers(Request $request)
    {
        $data = \App\Models\InsuranceProvider::select('insurance_providers.*')->distinct()
            ->join('providers_insurance_providers', 'providers_insurance_providers.insurance_provider_id', '=', 'insurance_providers.id');

        if ($request->has('provider_id') && is_numeric($request->get('provider_id'))) {
            $data = $data->where('providers_insurance_providers.provider_id', $request->get('provider_id'));
        }


        if ($request->has('speciality_groups')) {
            $speciality_groups = json_decode($request->get('speciality_groups'));
            if (is_array($speciality_groups) && sizeof($speciality_groups) > 0) {
                $data = $data->join('providers_speciality_groups',
                    'providers_speciality_groups.provider_id', '=', 'providers_insurance_providers.provider_id')
                    ->whereIn('providers_speciality_groups.platform_sub_category_id', $speciality_groups);
            }
        }

        if ($request->has('specialities')) {
            $specialities = json_decode($request->get('specialities'));
            if (is_array($specialities) && sizeof($specialities) > 0) {
                $data = $data->join('providers_specialities',
                    'providers_specialities.provider_id', '=', 'providers_insurance_providers.provider_id')
                    ->whereIn('providers_specialities.platform_sub_sub_category_id', $specialities);
            }
        }


        $data = $data->get();
        return parent::sendSuccess(trans('messages.Data Got!'), InsuranceProvider::collection($data));
    }


    public function search(Request $request)
    {

        $providers = Provider::select('providers.*')->distinct();


        if ((!$request->has('provider_id') || ($request->has('provider_id') && !is_numeric($request->get('provider_id')))) &&
            (!$request->has('facility_id') || ($request->has('facility_id') && !is_numeric($request->get('facility_id'))))) {


            if ($request->has('name') && strlen($request->get('name')) > 0) {
                $name = $request->get('name');
                $providers = $providers->where('full_name', 'like', '%' . $name . '%');
            }

            if ($request->has('insurance_provider')) {
                $insurance_provider = json_decode($request->get('insurance_provider'));
                if (is_array($insurance_provider) && sizeof($insurance_provider) > 0) {
                    $providers = $providers->join('providers_insurance_providers',
                        'providers_insurance_providers.provider_id', '=', 'providers.id')
                        ->whereIn('providers_insurance_providers.insurance_provider_id', $insurance_provider);
                }
            }else{
                if ($request->has('speciality_groups')) {
                    $speciality_groups = json_decode($request->get('speciality_groups'));
                    if (is_array($speciality_groups) && sizeof($speciality_groups) > 0) {
                        $providers = $providers->join('providers_speciality_groups',
                            'providers_speciality_groups.provider_id', '=', 'providers.id')
                            ->whereIn('providers_speciality_groups.platform_sub_category_id', $speciality_groups);
                    }
                }

                if ($request->has('specialities')) {
                    $specialities = json_decode($request->get('specialities'));
                    if (is_array($specialities) && sizeof($specialities) > 0) {
                        $providers = $providers->join('providers_specialities',
                            'providers_specialities.provider_id', '=', 'providers.id')
                            ->whereIn('providers_specialities.platform_sub_sub_category_id', $specialities);
                    }
                }
            }
        }

        if ($request->has('provider_id') && is_numeric($request->get('provider_id'))) {
            $facilities = \App\Models\ProvidersProfessional::where('professional_id',
                $request->get('provider_id'))->pluck('provider_id');
            $providers = $providers->whereIn('providers.id', $facilities);
        }

        if ($request->has('facility_id') && is_numeric($request->get('facility_id'))) {
            $facilities = \App\Models\ProvidersProfessional::where('provider_id',
                $request->get('facility_id'))->pluck('professional_id');
            $providers = $providers->whereIn('providers.id', $facilities);
        }


        $p = 0;
        $f = 0;
        if ($request->has('provider_type_id') && is_numeric($request->get('provider_type_id'))) {
            $providers->where('providers.provider_type_id', $request->get('provider_type_id'));
            if ($request->get('provider_type_id') == 1) {
                $p += 1;
            } else {
                $f += 1;
            }
        }


        $providers = $providers->get();

        if (!$request->has('provider_type_id')) {
            foreach ($providers as $pr) {
                if ($pr->provider_type_id == 1) {
                    $p += 1;
                } else {
                    $f += 1;
                }
            }
        }

        if ($request->has('provider_id') && is_numeric($request->get('provider_id'))) {
            $f += 10000000;
        }


        if ($request->has('facility_id') && is_numeric($request->get('facility_id'))) {
            $p += 10000000;
        }

        return parent::sendSuccess(trans('messages.Data Got!'), [
            'type' => $p > $f ? 'professionals' : 'facilities',
            'info' => ProviderBrefAppointment::collection($providers)
        ]);
    }

    public function slots(Request $request)
    {


        $data = AppointmentSlot::select('appointment_slots.*')->distinct();

        if ($request->has('professioanl_id') && is_numeric($request->get('professioanl_id'))) {
            $professioanl_id = json_decode($request->get('professioanl_id'));
            $data = $data->where('professional_id', $professioanl_id);
        }

        if ($request->has('facility_id') && is_numeric($request->get('facility_id'))) {
            $facility_id = json_decode($request->get('facility_id'));
            $data = $data->where('facility_id', $facility_id);
        }

        if ($request->has('appointment_type') && is_numeric($request->get('appointment_type'))) {
            $appointment_type = json_decode($request->get('appointment_type'));
            $data = $data->where('appointment_type', $appointment_type);
        }

        $data = $data->orderBy('created_at', 'asc')->get();
//        $data = \App\Resources\AppointmentSlot::collection($data);
        $times = getSlots($data);
//        foreach ($data as $d) {
//            $t = explode(' ', Carbon::parse($d->date_time)->toDateTimeString());
//            if (sizeof($t) >= 2) {
//                $times[Carbon::parse($t[0])->toDateTimeLocalString()][] = \App\Resources\AppointmentSlot::make($d);
//            }
//        }

        return parent::sendSuccess(trans('messages.Data Got!'), $times);
    }


    public function mySlots(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $data = [
            'total_size' => 0,
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => null
        ];

//        $provider = Provider::where('user_id', auth('sanctum')->user()->id)->first();

//        if ($provider) {
        $data = AppointmentSlot::
        where('provider_id', auth('sanctum')->user()->id)->
        orWhere('facility_id', auth('sanctum')->user()->id)->
        orWhere('professional_id', auth('sanctum')->user()->id);

        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\AppointmentSlot::collection($data->all())
        ];
//        }

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function clientAppointments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $data = [
            'total_size' => 0,
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => null
        ];

//        $provider = Provider::where('user_id', auth('sanctum')->user()->id)->first();

//        if ($provider) {
        $data = AppointmentClient::select('appointment_clients.*')->
        join('appointment_slots', 'appointment_clients.appointment_slot_id', '=', 'appointment_slots.id')
            ->where('appointment_slots.provider_id', auth('sanctum')->user()->id)->
            whereRaw(\DB::raw('date(appointment_slots.date_time)="' . Carbon::parse($request->get('date'))
                    ->toDateString() . '"'));

        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\AppointmentClient::collection($data->all())
        ];
//        }

        return parent::sendSuccess(trans('messages.Data Got!'), $data);

    }

    public function clientAppointmentsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:appointment_clients,id',
            'state' => 'required|in:1,2,3,4',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

//        $provider = Provider::where('user_id', auth('sanctum')->user()->id)->first();

//        if ($provider) {
        $data = AppointmentClient::
        select('appointment_clients.*')->
        join('appointment_slots', 'appointment_clients.appointment_slot_id', '=', 'appointment_slots.id')
            ->where('appointment_slots.provider_id', auth('sanctum')->user()->id)->
            where('appointment_clients.id', $request->get('id'))->first();

        if ($data) {
            $data->state = $request->get('state');
            $data->update();
            return parent::sendSuccess(trans('messages.Data Updated!'), null);
        }
//        }

        return parent::sendSuccess(trans('messages.Error in sent Data!'), null);
    }

    public function slotsDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:appointment_slots,id',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

//        $provider = Provider::where('user_id', auth('sanctum')->user()->id)->first();

//        if ($provider) {
        $data = AppointmentSlot::
        where('id', $request->get('id'))->
        where(function ($q) {
            return $q->where('provider_id', auth('sanctum')->user()->id)->
            orWhere('facility_id', auth('sanctum')->user()->id)->
            orWhere('professional_id', auth('sanctum')->user()->id);
        })->first();

        if ($data) {
            $data->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        }
//        }

        return parent::sendSuccess(trans('messages.Error in sent Data!'), null);

    }


    public function history(Request $request)
    {


        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $data = [
            'total_size' => 0,
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => null
        ];

//        $provider = Provider::where('user_id', auth('sanctum')->user()->id)->first();

//        if ($provider) {
        $data = AppointmentClient::select('appointment_clients.*')->
        join('appointment_slots', 'appointment_clients.appointment_slot_id', '=', 'appointment_slots.id');

        if ($request->has('state')) {
            $data = $data->where('appointment_clients.state', $request->get('state'));
        }

        $data = $data->where('appointment_slots.provider_id', auth('sanctum')->user()->id)->
        whereDate('appointment_slots.date_time', '<', Carbon::now()->toDateTimeString());

        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\AppointmentClient::collection($data->all())
        ];
//        }

        return parent::sendSuccess(trans('messages.Data Got!'), $data);

    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_slot_id' => 'required|numeric',
            'full_name' => 'required|string',
            'birthdate' => 'required|date',
            'mobile_number' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $id_front = '';
        if ($request->hasFile('id_front')) {
            $slug = 'appointment_clients';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'image')->first();
            $id_front = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }
        $id_back = '';
        if ($request->hasFile('id_back')) {
            $slug = 'appointment_clients';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'image')->first();
            $id_back = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }
        $insurance_front = '';
        if ($request->hasFile('insurance_front')) {
            $slug = 'appointment_clients';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'image')->first();
            $insurance_front = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }
        $insurance_back = '';
        if ($request->hasFile('insurance_back')) {
            $slug = 'appointment_clients';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'image')->first();
            $insurance_back = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }

        $data = new AppointmentClient();
        $data->for_who = $request->get('for_who');
        $data->professional_id = $request->get('professional_id');
        $data->facility_id = $request->get('facility_id');
        $data->insurance_id = $request->get('insurance_id');
        $data->appointment_slot_id = $request->get('appointment_slot_id');
        $data->full_name = $request->get('full_name');
        $data->birthdate = $request->get('birthdate');
        $data->id_number = $request->get('id_number');
        $data->mobile_number = $request->get('mobile_number');
        $data->email = $request->get('email');
        $data->id_front = $id_front;
        $data->id_back = $id_back;
        $data->insurance_front = $insurance_front;
        $data->insurance_back = $insurance_back;
        $data->from_type = getUserType();
        $data->comments = $request->get('comments');
        $data->user_id = auth('sanctum')->user()->id;
        $data->save();

        return parent::sendSuccess(trans('messages.Sent!'), \App\Resources\AppointmentClient::make($data));

    }


}
