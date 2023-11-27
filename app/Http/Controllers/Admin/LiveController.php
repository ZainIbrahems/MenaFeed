<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppointmentSlot;
use App\Models\AppointmentSlotDays;
use App\Models\AppointmentSlotTimes;
use App\Models\Live;
use App\Models\Provider;
use Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class LiveController extends VoyagerBaseController
{
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        $input = $request->all();
        $u_id = uniqid('mena_');
        do {
            $added_before = Live::where('code', '=', $u_id)->first() ? true : false;
            if (!$added_before) {
                $data->code = $u_id;
                $data->save();
            } else {
                $u_id = uniqid('mena_');
            }
        } while ($added_before);


        $provider = Provider::where('user_id',auth('web')->user()->id)->first();

        if($provider){
            Live::where([
                'added_by' => $provider->id
            ])->update([
                'status' => 0
            ]);

            Live::where('id', $data->id)->update([
                'added_by' => $provider->id,
                'status' => 1
            ]);
        }

        event(new BreadDataAdded($dataType, $data));

        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            } else {
                $redirect = redirect()->back();
            }

            return $redirect->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }
}
