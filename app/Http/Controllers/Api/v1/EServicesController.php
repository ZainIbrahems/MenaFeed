<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Resources\EservicesBanner;
use App\Resources\EservicesCategory;
use Illuminate\Http\Request;

class EServicesController extends Controller
{

    public function getInfo(Request $request)
    {
        $data = [];


        $data['banners'] = \App\Models\EservicesBanner::query();
        if ($request->has('platform_id') && is_numeric($request->get('platform_id'))) {
            $data['banners'] = $data['banners']->where('platform_id', $request->get('platform_id'));
        }
        $data['banners'] = $data['banners']->get();
        $data['banners'] = EservicesBanner::collection($data['banners']);


        $data['categories'] = \App\Models\EservicesCategory::query();
        if ($request->has('platform_id') && is_numeric($request->get('platform_id'))) {
            $data['categories'] = $data['categories']->where('platform_id', $request->get('platform_id'));
        }
        if ($request->has('text') && strlen($request->get('text')) > 0) {
            $data['categories'] = $data['categories']->where('title', 'like', '%' . $request->get('text') . '%');
        }
        $data['categories'] = $data['categories']->get();
        $data['categories'] = EservicesCategory::collection($data['categories']);


        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }
}
