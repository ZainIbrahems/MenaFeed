<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Validator;

class BloodRequestController extends Controller
{
    public function call(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $click_type = 'call';

        $user_type = getUserType();
        $user_id = auth('sanctum')->user()->id;

        BloodRequest::where('id', $request->get('id'))->where('user_id', NULL)->update([
            'user_type' => $user_type,
            'user_id' => $user_id,
            'click_type' => $click_type,
        ]);

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }

    public function direction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $click_type = 'direction';

        $user_type = getUserType();
        $user_id = auth('sanctum')->user()->id;

        BloodRequest::where('id', $request->get('id'))->where('user_id', NULL)->update([
            'user_type' => $user_type,
            'user_id' => $user_id,
            'click_type' => $click_type,
        ]);

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }


    public function send(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string',
            'blood_type' => 'required|string',
            'unit_quantity' => 'required|string',
            'hospital' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $data = new BloodRequest();
        $data->name = $request->get('name');
        $data->mobile = $request->get('mobile');
        $data->blood_type = $request->get('blood_type');
        $data->unit_quantity = $request->get('unit_quantity');
        $data->hospital = $request->get('hospital');
        if ($request->has('lat') && $request->has('lng')) {
            $data->location = \DB::raw("ST_GeomFromText('POINT({$request->get('lng')}{$request->get('lat')})')");
        }
        $data->save();

        try {
            send_push_notif_to_topic("Blood Request", "New Blood Request", [
                'name' => $request->get('name'),
                'mobile' => $request->get('mobile'),
                'blood_type' => $request->get('blood_type'),
                'unit_quantity' => $request->get('unit_quantity'),
                'hospital' => $request->get('hospital'),
                'lat' => $request->get('lat'),
                'lng' => $request->get('lng'),
            ]);
        } catch (\Exception $ex) {
            \Log::error($ex->getTraceAsString());
        }

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }
}
