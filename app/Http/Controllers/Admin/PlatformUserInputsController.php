<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformCategory;
use App\Models\PlatformSubCategory;
use App\Models\PlatformSubSubCategory;

class PlatformUserInputsController extends Controller
{

    function updateInputSpeciality($platform_id = NULL)
    {
        $data = [];
        if (!is_null($platform_id)) {
            $c1 = PlatformCategory::where('platform_id', $platform_id)->pluck('id');
            $c2 = PlatformSubCategory::whereIn('category_id', $c1)->pluck('id');
            $temp_data = PlatformSubSubCategory::select('id', 'name')->whereIn('sub_category_id', $c2)->get();
            foreach ($temp_data as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
        }
        return $data;
    }

    function updateSpecialityGroup($platform_category = NULL)
    {
        $data = [];
        if (!is_null($platform_category)) {
            $c2 = PlatformSubCategory::whereIn('category_id', [$platform_category])->get();
            foreach ($c2 as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
        }
        return $data;
    }

    function updateSpecialities($speciality_group = NULL)
    {
        $data = [];
        if (!is_null($speciality_group)) {
            $c2 = PlatformSubSubCategory::whereIn('sub_category_id', explode(',',$speciality_group))->get();
            foreach ($c2 as $td) {
                $data[] = [
                    'id' => $td->id,
                    'text' => $td->name
                ];
            }
        }
        return $data;
    }



}
