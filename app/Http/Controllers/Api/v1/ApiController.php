<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\AppointmentClient;
use App\Models\AppointmentSlot;
use App\Models\AppointmentSlotDays;
use App\Models\AppointmentSlotTimes;
use App\Models\Provider;
use App\Resources\InsuranceProvider;
use App\Resources\ProviderBrefAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Validator;

class ApiController extends Controller
{

    public function api($type, Request $request)
    {
        $data = null;
        switch ($type) {
            case 'air_quality':
                $lat = $request->get('lat');
                $lng = $request->get('lng');
                $fields = $request->get('fields');
                $data = json_decode(file_get_contents("https://api.tomorrow.io/v4/timelines?location=$lat,$lng&fields=$fields&timesteps=1h&units=metric&apikey=626v6P68Jw7bdXIBWU14bx2WMQXFdcmF&pollutantO3=ppb"));
                break;
            case 'weather_summary':
                $lat = $request->get('lat');
                $lng = $request->get('lng');
                $data = json_decode(file_get_contents("https://api.tomorrow.io/v4/weather/realtime?location=$lat,$lng&units=metric&apikey=626v6P68Jw7bdXIBWU14bx2WMQXFdcmF&pollutantO3=ppb"));
                break;
            case 'upcoming_days':
                $lat = $request->get('lat');
                $lng = $request->get('lng');
                $fields = $request->get('fields');
                $data = json_decode(file_get_contents("https://api.tomorrow.io/v4/timelines?location=$lat,$lng&fields=$fields&timesteps=1d&units=metric&apikey=626v6P68Jw7bdXIBWU14bx2WMQXFdcmF&pollutantO3=ppb"));
                break;
        }
        return parent::sendSuccess(trans('messages.Data Saved!'), $data);
    }
}
