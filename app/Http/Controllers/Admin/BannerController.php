<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformCategory;
use App\Models\PlatformSubCategory;
use App\Models\Provider;

class BannerController extends Controller
{

    function updateBannerResourceId($resource_type = NULL)
    {
        $data = [];
        if (!is_null($resource_type)) {
            switch ($resource_type) {
                case"category":
                    $temp_data = PlatformCategory::select('id', 'name')->get();
                    foreach ($temp_data as $td) {
                        $data[] = [
                            'id' => $td->id,
                            'text' => $td->name
                        ];
                    }
                    break;
                case"sub_category":
                    $temp_data = PlatformSubCategory::select('id', 'name')->get();
                    foreach ($temp_data as $td) {
                        $data[] = [
                            'id' => $td->id,
                            'text' => $td->name
                        ];
                    }
                    break;
                case"provider":
                    $temp_data = Provider::select('id', 'user_name')->get();
                    foreach ($temp_data as $td) {
                        $data[] = [
                            'id' => $td->id,
                            'text' => $td->user_name
                        ];
                    }
                    break;
                case"event":
                    break;
                case"webinar":
                    break;
                case"job":
                    break;
                case"article":
                    break;
                case"api":
                    $data[] = [
                        'id' => 'my_healthfinder',
                        'text' => 'My Health Finder'
                    ];
                    $data[] = [
                        'id' => 'air_quality',
                        'text' => 'Air Quality'
                    ];
                    $data[] = [
                        'id' => 'weather_summary',
                        'text' => 'Weather Summary'
                    ];
                    $data[] = [
                        'id' => 'upcoming_days',
                        'text' => 'Upcoming Days'
                    ];
                    break;
                case"none":
                    break;
            }
        }
        return $data;
    }

}
