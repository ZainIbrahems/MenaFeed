<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\ProviderEducation;
use App\Models\ProviderExperience;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Translation;
use Validator;

class ProviderExperienceController extends Controller
{
    public function save(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'place_of_work' => 'required|string',
            'designation' => 'required|string',
            'starting_year' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = new ProviderExperience();
        $data->provider_id = auth('sanctum')->user()->id;
        $data->place_of_work = $input['place_of_work'];
        $data->designation = $input['designation'];
        $data->starting_year = $input['starting_year'];
        $data->ending_year = $request->get('ending_year');
        $data->currently_working = isset($input['currently_working']) ? $input['currently_working'] : 0;
        $data->sort = 1;
        $data->save();

        Translation::updateOrCreate([
            'table_name' => 'provider_experiences',
            'column_name' => 'designation',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $input['designation']
        ]);

        Translation::updateOrCreate([
            'table_name' => 'provider_experiences',
            'column_name' => 'place_of_work',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $input['place_of_work']
        ]);

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderExperience::make($data));
    }

    public function edit(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
            'place_of_work' => 'required|string',
            'designation' => 'required|string',
            'starting_year' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderExperience::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderExperience::where('id', $input['id'])->update([
                'starting_year' => $input['starting_year'],
                'ending_year' => $request->get('ending_year'),
                'currently_working' => isset($input['currently_working']) ? $input['currently_working'] : 0,
                'sort' => ($request->has('sort') ? $input['sort'] : 1)
            ]);
            if (app()->getLocale() == 'en') {
                ProviderExperience::where('id', $input['id'])->update([
                    'place_of_work' => $input['place_of_work'],
                    'designation' => $input['designation'],
                ]);
            } else {
                Translation::updateOrCreate([
                    'table_name' => 'provider_experiences',
                    'column_name' => 'place_of_work',
                    'foreign_key' => $request->id,
                    'locale' => app()->getLocale(),
                ], [
                    'value' => $input['place_of_work']
                ]);
                Translation::updateOrCreate([
                    'table_name' => 'provider_experiences',
                    'column_name' => 'designation',
                    'foreign_key' => $request->id,
                    'locale' => app()->getLocale(),
                ], [
                    'value' => $input['designation']
                ]);
            }
            return parent::sendSuccess(trans('messages.Data Updated!'), \App\Resources\ProviderExperience::make($data));
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

    public function delete(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderExperience::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderExperience::where([
                'id' => $request->id,
                'provider_id' => auth('sanctum')->user()->id
            ])->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

}
