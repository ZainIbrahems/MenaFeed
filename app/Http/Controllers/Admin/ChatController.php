<?php

namespace App\Http\Controllers\Admin;

use App\Models\Provider;
use App\Models\ProviderAward;
use App\Models\ProviderEducation;
use App\Models\ProviderExperience;
use App\Models\ProviderFeature;
use App\Models\ProviderMembership;
use App\Models\ProviderPublication;
use App\Models\ProviderVacation;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use Validator;

class ChatController extends VoyagerBaseController
{


    public function index(Request $request)
    {
        return view('');
    }

}
