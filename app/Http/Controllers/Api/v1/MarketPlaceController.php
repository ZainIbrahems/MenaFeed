<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;

use App\Models\ItemCategory;
use App\Models\ItemSubCategory;
use App\Models\ItemSubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarketPlaceController extends Controller
{

    public function categories(Request $request)
    {
        $platform_id = $request->input('platform_id', null);
        $platform_category_id = $request->input('platform_category_id', null);
        $query = ItemCategory::query();
//        dd($platform_id);
        if ($platform_id !== null &&$platform_id !== "null" ) {
            $query->where('platform_id', $platform_id);
        }
        if ($platform_category_id !== null &&$platform_category_id !== "null" ) {
            $query->where('platform_category_id', $platform_category_id);
        }
        $data = \App\Resources\ItemCategory::collection($query->get());
        // Uncomment the following line if you want to debug the retrieved data
//         dd($query->get());
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function category(Request $request, $id = NULL)
    {
        if (ItemCategory::where('id', $id)->first()) {
            $data = \App\Resources\ItemCategory::make(ItemCategory::where('id', $id)->first());
        } else {
            $data = NULL;
        }
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function sub_category(Request $request, $id = NULL)
    {
        if (ItemCategory::where('id', $id)->first()) {
            $data = \App\Resources\ItemSubCategory::make(ItemSubCategory::where('id', $id)->first());
        } else {
            $data = NULL;
        }
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function sub_sub_category(Request $request, $id = NULL)
    {
        if (ItemCategory::where('id', $id)->first()) {
            $data = \App\Resources\ItemSubSubCategory::make(ItemSubSubCategory::where('id', $id)->first());
        } else {
            $data = NULL;
        }
        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

//    public function fields(Request $request)
//    {
//        if (auth('sanctum')->check()) {
//            $fields = \App\Resources\PlatformUserInput::collection(PlatformUserInput::where('platform_id', auth('sanctum')->user()->platform_id)->
//            whereIn('spciality_id', ProviderSpeciality::where('provider_id', auth('sanctum')->user()->id)->pluck('platform_sub_sub_category_id'))->get());
//        } else {
//            $fields = [];
//        }
//        return parent::sendSuccess(trans('messages.Data Got!'), $fields);
//    }
//
//    public function data(Request $request, $id = NULL)
//    {
//        if (is_null($id)) {
//            $id = auth('sanctum')->user()->platform_id;
//        }
//
//        $categories = \App\Resources\PlatformCategory::collection(
//            PlatformCategory::where('platform_id', $id)->
//            orderBy('ranking', 'asc')->get());
//        $banners = \App\Resources\Banner::collection(
//            Banner::where('platform_id', $id)->get());
//
//        $abbreviations = \App\Resources\Abbreviation::collection(
//            Abbreviation::where('platform_id', $id)->get());
//        $payment_gate_ways = \App\Resources\PaymentGateWay::collection(
//            PaymentGateWay::active()->get());
//
//        return parent::sendSuccess(trans('messages.Data Got!'), [
//            'banners' => $banners,
//            'categories' => $categories,
//            'abbreviations' => $abbreviations,
//            'payment_gate_ways' => $payment_gate_ways,
//        ]);
//    }
//
//
//    public function plans(Request $request, $id = NULL)
//    {
//
//        if (is_null($id) && auth('sanctum')->check()) {
//            $id = auth('sanctum')->user()->platform_id;
//        }
//
//        $subscription_types = \App\Resources\SubscriptionType::collection(
//            SubscriptionType::where('platform_id', $id)->get());
//
//        return parent::sendSuccess(trans('messages.Data Got!'), $subscription_types);
//    }
//
//    public function sections(Request $request, $id = NULL)
//    {
//
//        if (is_null($id) && auth('sanctum')->check()) {
//            $id = auth('sanctum')->user()->platform_id;
//        }
//
//        $sections = [];
//
//
//        return parent::sendSuccess(trans('messages.Data Got!'), $sections);
//    }
//
//
//    public function categoriesSelect2($platform_id = NULL)
//    {
//        $data = \App\Resources\PlatformCategorySelect2::collection(PlatformCategory::where('platform_id', $platform_id)->get());
////        Log::info($platform_id);
////        Log::info(json_encode($data));
//        $response = [
//            'results' => $data,
//            'pagination' => [
//                'more' => false
//            ]
//        ];
//        return response()->json($response);
//    }
}
