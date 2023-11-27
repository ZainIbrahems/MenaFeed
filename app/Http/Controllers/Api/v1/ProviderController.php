<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\PlatformCategory;
use App\Models\PlatformSubCategory;
use App\Models\PlatformSubSubCategory;
use App\Models\Provider;
use App\Resources\ProviderOnAir;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Validator;

class ProviderController extends Controller
{

    function updateProviderImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'personal_picture' => 'required',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $personal_picture = 'users/default.png';
        if ($request->hasFile('personal_picture')) {
            $slug = 'providers';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'personal_picture')->first();
            $personal_picture = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }

        $provider_id = auth('sanctum')->user()->id;
        Provider::where('id', $provider_id)->update([
            'personal_picture' => $personal_picture
        ]);

        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }

    function updateProviderAbout()
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'about' => 'nullable|string|min:0',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $provider_id = auth('sanctum')->user()->id;
        $about = $input['about'];
        Provider::where('id', $provider_id)->update([
            'about' => (!is_null($about) && strlen($about) > 0) ? $about : ''
        ]);

        return parent::sendSuccess(trans('messages.Data Updated!'), null);
    }

    public function list(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $providers = \App\Models\Provider::select('providers.*')->
        join('providers_specialities', 'providers_specialities.provider_id', '=', 'providers.id')->
        where('providers.status', 1);

        if ($request->has('sub_sub_category') &&
            is_numeric($request->get('sub_sub_category')) &&
            $request->get('sub_sub_category') > 0) {
            $providers = $providers->whereIn('providers_specialities.platform_sub_sub_category_id', [$request->get('sub_sub_category')]);
        } elseif ($request->has('sub_category') &&
            is_numeric($request->get('sub_category')) &&
            $request->get('sub_category') > 0) {
            $cat_ids = PlatformSubSubCategory::where('sub_category_id', $request->get('sub_category'))->pluck('id');
            $providers = $providers->whereIn('providers_specialities.platform_sub_sub_category_id', $cat_ids);
        } elseif ($request->has('category') &&
            is_numeric($request->get('category')) &&
            $request->get('category') > 0) {
            $cat_ids = PlatformSubCategory::where('category_id', $request->get('category'))->pluck('id');
            $cat_ids = PlatformSubSubCategory::whereIn('sub_category_id', $cat_ids)->pluck('id');
            $providers = $providers->whereIn('providers_specialities.platform_sub_sub_category_id', $cat_ids);
        }

        if ($request->has('name') && strlen($request->get('name')) > 0) {
            $providers = $providers->where('providers.full_name', 'like', '%' . $request->get('name') . '%');
        }

        $providers = $providers->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $providers->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\ProviderBref::collection($providers->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function details($id)
    {
        $provider = \App\Models\Provider::where('id', $id)->first();
        $provider = \App\Resources\Provider::make($provider);

        return parent::sendSuccess(trans('messages.Data Got!'), $provider);
    }

    public function categoryDetails(Request $request)
    {
        $providers = \App\Models\Provider::select('providers.*')->distinct()->
        join('providers_specialities', 'providers_specialities.provider_id', '=', 'providers.id')->
        where('providers.status', 1);

        if ($request->has('sub_sub_category') &&
            is_numeric($request->get('sub_sub_category')) &&
            $request->get('sub_sub_category') > 0) {
            $providers->whereIn('providers_specialities.platform_sub_sub_category_id', [$request->get('sub_sub_category')]);
            $cat = \App\Resources\PlatformSubSubCategory::make(PlatformSubSubCategory::where('id', $request->get('sub_sub_category'))->first());
        } elseif ($request->has('sub_category') &&
            is_numeric($request->get('sub_category')) &&
            $request->get('sub_category') > 0) {
            $cat_ids = PlatformSubSubCategory::where('sub_category_id', $request->get('sub_category'))->pluck('id');
            $providers->whereIn('providers_specialities.platform_sub_sub_category_id', $cat_ids);
            $cat = \App\Resources\PlatformSubCategory::make(PlatformSubCategory::where('id', $request->get('sub_category'))->first());
        } elseif ($request->has('category') &&
            is_numeric($request->get('category')) &&
            $request->get('category') > 0) {
            $cat_ids = PlatformSubCategory::where('category_id', $request->get('category'))->pluck('id');
            $cat_ids = PlatformSubSubCategory::whereIn('sub_category_id', $cat_ids)->pluck('id');
            $providers->whereIn('providers_specialities.platform_sub_sub_category_id', $cat_ids);
            $cat = \App\Resources\PlatformCategory::make(PlatformCategory::where('id', $request->get('category'))->first());
        }

//        $providers = $providers->paginate(20, ['*'], 'page', 1);
//        $providers = \App\Resources\ProviderBref::collection($providers->items());
        $providers2 = $providers->get();
        $providers = \App\Resources\ProviderBref::collection($providers2);
        $response = [];
        $responses = [];
        $sections = ['providers_on_air', 'providers', 'providers_nearby', 'events_nearby', 'banner'];

        $responses['category'] = $cat;

        foreach ($sections as $section) {
            $response['data']['providers_on_air'] = null;
            $response['data']['providers'] = null;
            $response['data']['providers_nearby'] = null;
            $response['data']['events_nearby'] = null;
            $response['data']['banner'] = null;
            $response['type'] = $section;
            $response['style'] = '';
            $response['title'] = str_replace('_', ' ', $section);

            switch ($section) {
                case 'providers_on_air':
                    $response['data']['providers_on_air'] = ProviderOnAir::collection($providers2);
                    break;
                case 'providers':
                    $response['data']['providers'] = $providers;
                    break;

                case 'providers_nearby':
                    $response['data']['providers_nearby'] = getProviderNearBy($request);
                    break;

                case 'events_nearby':
                    $response['data']['events_nearby'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.21048',
                            'lng' => '55.27108'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.20548',
                            'lng' => '55.24708'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.20548',
                            'lng' => '55.27508'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.26048',
                            'lng' => '55.27608'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.220428',
                            'lng' => '55.27708'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.220428',
                            'lng' => '55.27208'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.230438',
                            'lng' => '55.23708'
                        ]
                    ];
                    break;
                case 'banner':
                    $response['data']['banner'] = [
                        [
                            'id' => 1,
                            'title' => '',
                            'platform_id' => 1,
                            'url' => '#',
                            'resource_type' => 'category',
                            'resource_id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'banner_in_line' => 1,
                        ],
                        [
                            'id' => 1,
                            'title' => '',
                            'platform_id' => 1,
                            'url' => '#',
                            'resource_type' => 'category',
                            'resource_id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'banner_in_line' => 1,
                        ],
                        [
                            'id' => 1,
                            'title' => '',
                            'platform_id' => 1,
                            'url' => '#',
                            'resource_type' => 'category',
                            'resource_id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'banner_in_line' => 1,
                        ],
                        [
                            'id' => 1,
                            'title' => '',
                            'platform_id' => 1,
                            'url' => '#',
                            'resource_type' => 'category',
                            'resource_id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'banner_in_line' => 1,
                        ],
                        [
                            'id' => 1,
                            'title' => '',
                            'platform_id' => 1,
                            'url' => '#',
                            'resource_type' => 'category',
                            'resource_id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'banner_in_line' => 1,
                        ],
                    ];
                    break;
            }
            $responses['data'][] = $response;
        }

        return parent::sendSuccess(trans('messages.Data Got!'), $responses);
    }

}
