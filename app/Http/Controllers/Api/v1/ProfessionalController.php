<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\PlatformSubSubCategory;
use App\Models\Provider;
use App\Models\ProvidersProfessional;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{

    public function getMy(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $user = json_decode(auth('sanctum')->user());
        $user_id = auth('sanctum')->user()->id;

        $data = Provider::where('added_by', $user_id);
        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $specialities = PlatformSubSubCategory::select('platform_sub_sub_categories.*')->distinct()->
        join('providers_specialities', 'providers_specialities.platform_sub_sub_category_id', '=', 'platform_sub_sub_categories.id')->
        join('providers', 'providers.id', '=', 'providers_specialities.provider_id')->
        where('providers.added_by', '=', $user_id)->
        get();


        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\Provider::collection($data->all()),
            'specialities' => \App\Resources\PlatformSubSubCategory::collection($specialities),
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getAll(Request $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;


        $provider = Provider::where('id', $request->get('provider_id'))->first();

        if ($provider) {

            $sp = ProvidersProfessional::where('provider_id', $provider->id)->pluck('professional_id');

            $data = Provider::select('providers.*')->whereIn('id', $sp);
            if ($request->has('speciality_id')) {
                $data = $data->distinct()->
                join('providers_specialities', 'providers_specialities.provider_id', '=', 'providers.id')->
                join('platform_sub_sub_categories', 'platform_sub_sub_categories.id', '=', 'providers_specialities.platform_sub_sub_category_id')->
                whereIn('platform_sub_sub_categories.id', [$request->get('speciality_id')]);
            }
            $data = $data->where('status', 1)->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

            $specialities = PlatformSubSubCategory::select('platform_sub_sub_categories.*')->distinct()->
            join('providers_specialities', 'providers_specialities.platform_sub_sub_category_id', '=', 'platform_sub_sub_categories.id')->
            join('providers', 'providers.id', '=', 'providers_specialities.provider_id')->
            where('providers.added_by', $provider->user_id);
            $specialities = $specialities->get();

            $all_data = [
                'total_size' => $data->total(),
                'limit' => (int)$limit,
                'offset' => (int)$offset,
                'data' => \App\Resources\Provider::collection($data->all()),
                'specialities' => \App\Resources\PlatformSubSubCategory::collection($specialities),
            ];
        } else {
            $all_data = [
                'total_size' => 0,
                'limit' => (int)$limit,
                'offset' => (int)$offset,
                'data' => [],
                'specialities' => [],
            ];
        }


        return parent::sendSuccess(trans('messages.Data Got!'), $all_data);
    }


}
