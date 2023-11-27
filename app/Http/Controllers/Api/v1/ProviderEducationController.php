<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\ProviderEducation;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Translation;
use Validator;

class ProviderEducationController extends Controller
{
    public function saveEducation(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'university_name' => 'required|string',
            'degree' => 'required|string|min:0',
            'starting_year' => 'required|string:max:4',
            'currently_pursuing' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = new ProviderEducation();
        $data->provider_id = auth('sanctum')->user()->id;
        $data->university_name = $input['university_name'];
        $data->degree = $input['degree'];
        $data->starting_year = $input['starting_year'];
        $data->ending_year = $request->has('ending_year') ? $request->get('ending_year') : NULL;
        $data->currently_pursuing = $input['currently_pursuing'];
        $data->sort = 1;
        $data->save();


        Translation::updateOrCreate([
            'table_name' => 'providers_educations',
            'column_name' => 'university_name',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $input['university_name']
        ]);

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderEducation::make($data));
    }

    public function editEducation(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
            'university_name' => 'required|string',
            'degree' => 'required|string|min:0',
            'starting_year' => 'required|string:max:4',
            'currently_pursuing' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderEducation::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            $data->degree = $input['degree'];
            $data->starting_year = $input['starting_year'];
            $data->ending_year = $request->has('ending_year') ? $request->get('ending_year') : NULL;
            $data->currently_pursuing = $input['currently_pursuing'];
            $data->sort = $request->has('sort') ? $input['sort'] : 1;
            $data->save();
            if (app()->getLocale() == 'en') {
                ProviderEducation::where('id', $input['id'])->update([
                    'university_name' => $input['university_name'],
                ]);
            } else {
                Translation::updateOrCreate([
                    'table_name' => 'providers_educations',
                    'column_name' => 'university_name',
                    'foreign_key' => $request->id,
                    'locale' => app()->getLocale(),
                ], [
                    'value' => $input['university_name']
                ]);
            }
            return parent::sendSuccess(trans('messages.Data Updated!'), \App\Resources\ProviderEducation::make($data));
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

    public function deleteEducation(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderEducation::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderEducation::where([
                'id' => $request->id,
                'provider_id' => auth('sanctum')->user()->id
            ])->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

}
