<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppointmentSlot;
use App\Models\AppointmentSlotDays;
use App\Models\AppointmentSlotTimes;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class AppointmentsController extends VoyagerBaseController
{

    function appointments_payment_list()
    {
        return view('appointments.appointments_payment_list');
    }

    function appointments_providers_list()
    {
        return view('appointments.appointments_providers_list');
    }

    function appointments_create_my_availability()
    {
        return view('appointments.appointments_create_my_availability');
    }

    function appointments_my_availability_list()
    {
        return view('appointments.appointments_my_availability_list');
    }

    function appointment_clients_providers(Request $request)
    {

        $slug = 'appointment-slots';

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
//        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object)['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        if ($dataType->server_side) {
            $searchNames = $dataType->browseRows->mapWithKeys(function ($row) {
                return [$row['field'] => $row->getTranslatedAttribute('display_name')];
            });
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;
        $showPastLivestreams = false;

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            $query = $model::select($dataType->name . '.*');

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query->{$dataType->scope}();
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }

            }


            if ($request->get('showPastLivestreams')) {
                $showPastLivestreams = true;
                $query = $query->where('date_time', '<', Carbon::now()->toDateTimeString());
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';
                $row = $this->findSearchableRelationshipRow($dataType->rows->where('type', 'relationship'), $search->key);
                if ($row) {
                    $searchField = $dataType->name . '.' . $row->details->column;
                    $query->whereIn(
                        $searchField,
                        $row->details->model::where($row->details->label, $search_filter, $search_value)->pluck('id')->toArray()
                    );
                } else {
                    $searchField = $dataType->name . '.' . $search->key;
                    if ($dataType->browseRows->pluck('field')->contains($search->key)) {
                        $query->where($searchField, $search_filter, $search_value);
                    }
                }

            }

            $row = $dataType->rows->where('field', $orderBy)->firstWhere('type', 'relationship');
            if ($orderBy && (in_array($orderBy, $dataType->fields()) || !empty($row))) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                if (!empty($row)) {
                    $query->select([
                        $dataType->name . '.*',
                        'joined.' . $row->details->label . ' as ' . $orderBy,
                    ])->leftJoin(
                        $row->details->table . ' as joined',
                        $dataType->name . '.' . $row->details->column,
                        'joined.' . $row->details->key
                    );
                }

                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        // Actions
        $actions = [];
        if (!empty($dataTypeContent->first())) {
            foreach (Voyager::actions() as $action) {
                $action = new $action($dataType, $dataTypeContent->first());

                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        // Define showCheckboxColumn
        $showCheckboxColumn = false;
        if (Auth::user()->can('delete', app($dataType->model_name))) {
            $showCheckboxColumn = true;
        } else {
            foreach ($actions as $action) {
                if (method_exists($action, 'massAction')) {
                    $showCheckboxColumn = true;
                }
            }
        }

        // Define orderColumn
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
            $orderColumn = [[$index, $sortOrder ?? 'desc']];
        }

        // Define list of columns that can be sorted server side
        $sortableColumns = $this->getSortableColumns($dataType->browseRows);

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'actions',
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortableColumns',
            'sortOrder',
            'searchNames',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'showPastLivestreams',
            'showCheckboxColumn'
        ));
    }

    function appointment_slots_providers(Request $request)
    {
        $slug = 'appointment-clients';

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
//        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object)['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        if ($dataType->server_side) {
            $searchNames = $dataType->browseRows->mapWithKeys(function ($row) {
                return [$row['field'] => $row->getTranslatedAttribute('display_name')];
            });
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;
        $showPastLivestreams = false;

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            $query = $model::select($dataType->name . '.*');

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query->{$dataType->scope}();
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }

            }


            if ($request->get('showPastLivestreams')) {
                $showPastLivestreams = true;
                $query = $query->where('date_time', '<', Carbon::now()->toDateTimeString());
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';
                $row = $this->findSearchableRelationshipRow($dataType->rows->where('type', 'relationship'), $search->key);
                if ($row) {
                    $searchField = $dataType->name . '.' . $row->details->column;
                    $query->whereIn(
                        $searchField,
                        $row->details->model::where($row->details->label, $search_filter, $search_value)->pluck('id')->toArray()
                    );
                } else {
                    $searchField = $dataType->name . '.' . $search->key;
                    if ($dataType->browseRows->pluck('field')->contains($search->key)) {
                        $query->where($searchField, $search_filter, $search_value);
                    }
                }

            }

            $row = $dataType->rows->where('field', $orderBy)->firstWhere('type', 'relationship');
            if ($orderBy && (in_array($orderBy, $dataType->fields()) || !empty($row))) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                if (!empty($row)) {
                    $query->select([
                        $dataType->name . '.*',
                        'joined.' . $row->details->label . ' as ' . $orderBy,
                    ])->leftJoin(
                        $row->details->table . ' as joined',
                        $dataType->name . '.' . $row->details->column,
                        'joined.' . $row->details->key
                    );
                }

                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        // Actions
        $actions = [];
        if (!empty($dataTypeContent->first())) {
            foreach (Voyager::actions() as $action) {
                $action = new $action($dataType, $dataTypeContent->first());

                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        // Define showCheckboxColumn
        $showCheckboxColumn = false;
        if (Auth::user()->can('delete', app($dataType->model_name))) {
            $showCheckboxColumn = true;
        } else {
            foreach ($actions as $action) {
                if (method_exists($action, 'massAction')) {
                    $showCheckboxColumn = true;
                }
            }
        }

        // Define orderColumn
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
            $orderColumn = [[$index, $sortOrder ?? 'desc']];
        }

        // Define list of columns that can be sorted server side
        $sortableColumns = $this->getSortableColumns($dataType->browseRows);

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'actions',
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortableColumns',
            'sortOrder',
            'searchNames',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'showPastLivestreams',
            'showCheckboxColumn'
        ));
    }


    function appointments_clients_list()
    {
        return view('appointments.appointments_clients_list');
    }

    function saveAppointmentDataTime(Request $request)
    {

        if ($request->has('time_from') && is_array($request->get('time_from')) &&
            sizeof($request->get('time_from')) <= 0) {
            return redirect()->back()->with([
                'message' => "Please Add Times!",
                'alert-type' => 'error',
            ]);
        }

        if ($request->has('days') && is_array($request->get('days')) &&
            sizeof($request->get('days')) <= 0) {
            return redirect()->back()->with([
                'message' => "Please Add Days!",
                'alert-type' => 'error',
            ]);
        }

        $check = checkSlots($request->get('days'), $request->get('time_from'), $request->get('time_to'), $request->get('provider_id'));
        if (!$check['status']) {
            return redirect()->back()->with([
                'message' => "Some slot times not available! <br/> Day: " . $check['d'] . ' - Time From: '
                    . $check['tf'] . ' - Time To: ' . $check['tt'],
                'alert-type' => 'error',
            ]);
        }

        $app = new AppointmentSlot();
        $app->provider_id = $request->get('provider_id');
        $app->date_time = $request->get('date_time');
        $app->appointment_type = $request->get('appointment_type');
        $app->facility_id = $request->get('facility_id') > 0 ? $request->get('facility_id') : NULL;
        $app->professional_id = $request->get('professional_id') > 0 ? $request->get('professional_id') : NULL;
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

        return redirect()->back()->with([
            'message' => "Data Saved!",
            'alert-type' => 'success',
        ]);
    }

    function updateAppointmentDataTime(Request $request)
    {

        if ($request->has('time_from') && is_array($request->get('time_from')) &&
            sizeof($request->get('time_from')) <= 0) {
            return redirect()->back()->with([
                'message' => "Please Add Times!",
                'alert-type' => 'error',
            ]);
        }

        if ($request->has('days') && is_array($request->get('days')) &&
            sizeof($request->get('days')) <= 0) {
            return redirect()->back()->with([
                'message' => "Please Add Days!",
                'alert-type' => 'error',
            ]);
        }

        $check = checkSlots($request->get('days'), $request->get('time_from'), $request->get('time_to'), $request->get('provider_id'));
        if (!$check['status']) {
            return redirect()->back()->with([
                'message' => "Some slot times not available! <br/> Day: " . $check['d'] . ' - Time From: '
                    . $check['tf'] . ' - Time To: ' . $check['tt'],
                'alert-type' => 'error',
            ]);
        }

        $app = AppointmentSlot::where('id', $request->get('slot_id'))->first();
        $app->provider_id = $request->get('provider_id');
        $app->date_time = $request->get('date_time');
        $app->appointment_type = $request->get('appointment_type');
        $app->facility_id = $request->get('facility_id') > 0 ? $request->get('facility_id') : NULL;
        $app->professional_id = $request->get('professional_id') > 0 ? $request->get('professional_id') : NULL;
        $app->fees = $request->get('fees');
        $app->currency = $request->get('currency');
        $app->update();

        AppointmentSlotTimes::where('slot_id', $request->get('slot_id'))->delete();
        foreach ($request->get('time_from') as $key => $t) {
            $st = new AppointmentSlotTimes();
            $st->from_time = $t;
            $st->to_time = $request->get('time_to')[$key];
            $st->slot_id = $app->id;
            $st->save();
        }

        AppointmentSlotDays::where('slot_id', $request->get('slot_id'))->delete();
        foreach ($request->get('days') as $key => $t) {
            $st = new AppointmentSlotDays();
            $st->day = $t;
            $st->slot_id = $app->id;
            $st->save();
        }

        return redirect()->back()->with([
            'message' => "Data Saved!",
            'alert-type' => 'success',
        ]);
    }

}
