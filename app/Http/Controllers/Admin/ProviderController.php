<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeSection;
use App\Models\ItemCategory;
use App\Models\ItemSubCategory;
use App\Models\LiveNowCategory;
use App\Models\PlatformCategory;
use App\Models\Provider;
use App\Models\ProviderAward;
use App\Models\ProviderEducation;
use App\Models\ProviderExperience;
use App\Models\ProviderFeature;
use App\Models\ProviderMembership;
use App\Models\ProviderPublication;
use App\Models\ProviderSpeciality;
use App\Models\ProviderVacation;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use Validator;

class ProviderController extends VoyagerBaseController
{


    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);


        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        $query = $model->query();
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $query = $query->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $query = $query->withTrashed();
        }

        $data = $query->findOrFail($id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();

        $provider = Provider::where('id', $id)->first();
        $user = User::where('id', $provider->user_id)->first();
        if ($user) {
            if ($request->has('password') && strlen($request->get('password')) > 3) {
                $user->password = bcrypt($request->password);
            }
            $user->email = $request->email;
            $user->platform_id = $request->platform_id;
            $user->full_name = $request->full_name;
            $user->phone = $request->phone;
            $user->update();
        }

        // Get fields with images to remove before updating and make a copy of $data
        $to_remove = $dataType->editRows->where('type', 'image')
            ->filter(function ($item, $key) use ($request) {
                return $request->hasFile($item->field);
            });
        $original_data = clone($data);

        $data = $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        // Delete Images
        $this->deleteBreadImages($original_data, $to_remove);

        event(new BreadDataUpdated($dataType, $data));

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        return $redirect->with([
            'message' => __('voyager::generic.successfully_updated') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

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
        $show_added_by_providers = false;

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

            if ($request->get('show_added_by_providers')) {
                $show_added_by_providers = true;
                $query = $query->where('added_by', '<>', NULL);
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
            'show_added_by_providers',
            'showCheckboxColumn'
        ));
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            $data->added_by = auth('web')->user()->id;
            $data->update();
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

        $data->user_id = $user_dashboard->id;
        $data->update();

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

    function updateProviderOptions()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'features' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $provider_id = $input['provider_id'];
        $features = $input['features'];
        ProviderFeature::where('provider_id', $provider_id)->delete();
        foreach ($features as $f) {
            $pf = new ProviderFeature();
            $pf->provider_id = $provider_id;
            $pf->feature_id = $f;
            $pf->save();
        }


        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updateProviderAbout()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'about' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $provider_id = $input['provider_id'];
        $about = $input['about'];
        Provider::where('id', $provider_id)->update([
            'about' => $about
        ]);

        $array = json_decode(request()->about_i18n);
        updateTranslation('providers', $array, 'about', $provider_id);


        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updatePlatform($platform_id = NULL)
    {
        $data = [];
        if (!is_null($platform_id)) {
            $c2 = PlatformCategory::whereIn('platform_id', [$platform_id])->get();
            foreach ($c2 as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
        }
        return $data;
    }

    function updateProfessionals($specialities = NULL)
    {
        $data = [];
        if (!is_null($specialities)) {
            $sp = ProviderSpeciality::distinct()->where('platform_sub_sub_category_id', json_decode($specialities))->pluck('provider_id');
            $c2 = Provider::
            distinct()->
            whereIn('id', $sp)->
            where('id', '<>', auth('web')->user()->id)->
            where('provider_type_id', 1)->
            where('verified', 1)->
            where('status', 1)->
            get();
            foreach ($c2 as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->full_name
                ];
            }
        }
//        \Log::info($data);
        return $data;
    }

    function updateCategoryHomeSections($platform_id = NULL)
    {
        $data = [];
        if (!is_null($platform_id)) {
            $sp = HomeSection::distinct()->where('platform_id', $platform_id)->get();
            foreach ($sp as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->title
                ];
            }
        }
//        \Log::info($data);
        return $data;
    }


    function updateCategoryMarketPlace($platform_id = NULL)
    {
        $data = [];
        if (!is_null($platform_id)) {
            $sp = PlatformCategory::distinct()->where('platform_id', $platform_id)->get();
            foreach ($sp as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
        }
//        dd($data);
//        \Log::info($data);
        return $data;
    }


    function updateItemCategoryMarketPlace($platform_id = NULL)
    {
        $data = [];
        if (!is_null($platform_id)) {
            $sp = ItemCategory::distinct()->where('platform_id', $platform_id)->get();
            foreach ($sp as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
        }
//        dd($data);
//        \Log::info($data);
        return $data;
    }

    function updateItemSubCategoryMarketPlace($item_category_id = NULL)
    {
        $data = [];
        if (!is_null($item_category_id)) {
            $sp = ItemSubCategory::distinct()->where('item_category_id', $item_category_id)->get();
            foreach ($sp as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
        }
//        dd($data);
//        \Log::info($data);
        return $data;
    }




    function updatePlatformId($platform_id = NULL)
    {
        $data['LiveNowCategory'] = [];
        $data['LiveUpcomingCategory'] = [];
        $data['Provider'] = [];
        if (!is_null($platform_id)) {
            $sp = LiveNowCategory::where('platform_id', $platform_id)->where('type','live_now')->get();
            foreach ($sp as $td) {
                $data['LiveNowCategory'][] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
            $sp = LiveNowCategory::where('platform_id', $platform_id)->where('type','upcoming')->get();
            foreach ($sp as $td) {
                $data['LiveUpcomingCategory'][] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
            $sp = Provider::where('platform_id', $platform_id)->get();
            foreach ($sp as $td) {
                $data['Provider'][] = [
                    'id' => $td->id,
                    'text' => $td->full_name
                ];
            }
        }

        return $data;
    }

    function saveEducation()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'university_name' => 'required|string',
            'degree' => 'required|string|min:0',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $data = new ProviderEducation();
        $data->provider_id = $input['provider_id'];
        $data->university_name = $input['university_name'];
        $data->degree = $input['degree'];
        $data->sort = $input['sort'];
        $data->save();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updateEducation()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:providers_educations,id',
            'university_name' => 'required|string',
            'degree' => 'required|string|min:0',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderEducation::where('id', $input['id'])->update([
            'university_name' => $input['university_name'],
            'degree' => $input['degree'],
            'sort' => $input['sort']
        ]);

        $array = json_decode(request()->university_name_i18n);
        updateTranslation('providers_educations', $array, 'university_name', $input['id']);

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function deleteEducation()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:providers_educations,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderEducation::where('id', $input['id'])->delete();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function saveExperience()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'place_of_work' => 'required|string',
            'designation' => 'required|string',
            'starting_year' => 'required|date',
            'ending_year' => 'required|date',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $data = new ProviderExperience();
        $data->provider_id = $input['provider_id'];
        $data->place_of_work = $input['place_of_work'];
        $data->designation = $input['designation'];
        $data->starting_year = $input['starting_year'];
        $data->ending_year = $input['ending_year'];
        $data->currently_working = isset($input['currently_working']) ? 1 : 0;
        $data->sort = $input['sort'];
        $data->save();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updateExperience()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:provider_experiences,id',
            'place_of_work' => 'required|string',
            'designation' => 'required|string',
            'starting_year' => 'required|date',
            'ending_year' => 'required|date',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderExperience::where('id', $input['id'])->update([
            'place_of_work' => $input['place_of_work'],
            'designation' => $input['designation'],
            'starting_year' => $input['starting_year'],
            'ending_year' => $input['ending_year'],
            'currently_working' => isset($input['currently_working']) ? 1 : 0,
            'sort' => $input['sort']
        ]);

        $array = json_decode(request()->place_of_work_i18n);
        updateTranslation('provider_experiences', $array, 'place_of_work', $input['id']);

        $array = json_decode(request()->designation_i18n);
        updateTranslation('provider_experiences', $array, 'designation', $input['id']);


        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function deleteExperience()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:provider_experiences,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderExperience::where('id', $input['id'])->delete();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }


    function savePublication()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'paper_title' => 'required|string',
            'summary' => 'required|string',
            'publisher' => 'required|string',
            'published_url' => 'required|string',
            'published_date' => 'required|date',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $data = new ProviderPublication();
        $data->provider_id = $input['provider_id'];
        $data->paper_title = $input['paper_title'];
        $data->summary = $input['summary'];
        $data->publisher = $input['publisher'];
        $data->published_url = $input['published_url'];
        $data->published_date = $input['published_date'];
        $data->sort = $input['sort'];
        $data->save();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updatePublication()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:providers_publications,id',
            'paper_title' => 'required|string',
            'summary' => 'required|string',
            'publisher' => 'required|string',
            'published_url' => 'required|string',
            'published_date' => 'required|date',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderPublication::where('id', $input['id'])->update([
            'paper_title' => $input['paper_title'],
            'summary' => $input['summary'],
            'publisher' => $input['publisher'],
            'published_url' => $input['published_url'],
            'published_date' => $input['published_date'],
            'sort' => $input['sort']
        ]);

        $array = json_decode(request()->paper_title_i18n);
        updateTranslation('providers_publications', $array, 'paper_title', $input['id']);

        $array = json_decode(request()->summary_i18n);
        updateTranslation('providers_publications', $array, 'summary', $input['id']);

        $array = json_decode(request()->publisher_i18n);
        updateTranslation('providers_publications', $array, 'publisher', $input['id']);

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function deletePublication()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:providers_publications,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderPublication::where('id', $input['id'])->delete();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }


    function saveVacations()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'certificate_name' => 'required|string',
            'issue_date' => 'required|date',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $data = new ProviderVacation();
        $data->provider_id = $input['provider_id'];
        $data->certificate_name = $input['certificate_name'];
        $data->issue_date = $input['issue_date'];
        $data->sort = $input['sort'];
        $data->save();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updateVacations()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:provider_vacations,id',
            'certificate_name' => 'required|string',
            'issue_date' => 'required|date',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderVacation::where('id', $input['id'])->update([
            'certificate_name' => $input['certificate_name'],
            'issue_date' => $input['issue_date'],
            'sort' => $input['sort']
        ]);


        $array = json_decode(request()->certificate_name_i18n);
        updateTranslation('provider_vacations', $array, 'certificate_name', $input['id']);


        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function deleteVacations()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:provider_vacations,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderVacation::where('id', $input['id'])->delete();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }


    function saveMembership()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'name' => 'required|string',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $data = new ProviderMembership();
        $data->provider_id = $input['provider_id'];
        $data->name = $input['name'];
        $data->sort = $input['sort'];
        $data->save();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updateMembership()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:provider_membership,id',
            'name' => 'required|string',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderMembership::where('id', $input['id'])->update([
            'name' => $input['name'],
            'sort' => $input['sort']
        ]);

        $array = json_decode(request()->name_i18n);
        updateTranslation('provider_membership', $array, 'name', $input['id']);

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function deleteMembership()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:provider_membership,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderMembership::where('id', $input['id'])->delete();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function saveAward()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
            'title' => 'required|string',
            'authority_name' => 'required|string',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $data = new ProviderAward();
        $data->provider_id = $input['provider_id'];
        $data->title = $input['title'];
        $data->authority_name = $input['authority_name'];
        $data->sort = $input['sort'];
        $data->save();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function updateAward()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric|exists:provider_awards,id',
            'title' => 'required|string',
            'authority_name' => 'required|string',
            'sort' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderAward::where('id', $input['id'])->update([
            'title' => $input['title'],
            'authority_name' => $input['authority_name'],
            'sort' => $input['sort']
        ]);


        $array = json_decode(request()->title_i18n);
        updateTranslation('provider_awards', $array, 'title', $input['id']);


        $array = json_decode(request()->authority_name_i18n);
        updateTranslation('provider_awards', $array, 'authority_name', $input['id']);

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }


    function deleteAward()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        ProviderAward::where('id', $input['id'])->delete();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

    function saveContact()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'provider_id' => 'required|numeric|exists:providers,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => "Error in sent data!",
                'alert-type' => 'error',
            ]);
        }

        $p = Provider::where('id', $input['provider_id'])->first();

        if (isset($input['website'])) {
            $p->website = $input['website'];
        }
        if (isset($input['public_email'])) {
            $p->public_email = $input['public_email'];
        }
        if (isset($input['telephone'])) {
            $p->telephone = $input['telephone'];
        }
        if (isset($input['whatsapp'])) {
            $p->whatsapp = $input['whatsapp'];
        }
        if (isset($input['instagram'])) {
            $p->instagram = $input['instagram'];
        }
        if (isset($input['facebook'])) {
            $p->facebook = $input['facebook'];
        }
        if (isset($input['pinterest'])) {
            $p->pinterest = $input['pinterest'];
        }
        if (isset($input['youtube'])) {
            $p->youtube = $input['youtube'];
        }

        if (isset($input['tiktok'])) {
            $p->tiktok = $input['tiktok'];
        }

        $p->update();

        return redirect()->back()->with([
            'message' => "Done!",
            'alert-type' => 'success',
        ]);

    }

}
