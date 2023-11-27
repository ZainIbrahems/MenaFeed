<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\ProviderVacation;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Translation;
use Validator;

class ProviderCertificateController extends Controller
{
    public function save(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'certificate_name' => 'required|string',
            'issue_date' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = new ProviderVacation();
        $data->provider_id = auth('sanctum')->user()->id;
        $data->certificate_name = $input['certificate_name'];
        $data->issue_date = $input['issue_date'];
        $data->sort = 1;
        $data->save();


        Translation::updateOrCreate([
            'table_name' => 'provider_vacations',
            'column_name' => 'certificate_name',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $input['certificate_name']
        ]);

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderVacation::make($data));
    }

    public function edit(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
            'certificate_name' => 'required|string',
            'issue_date' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderVacation::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderVacation::where('id', $input['id'])->update([
                'issue_date' => $input['issue_date'],
                'sort' => ($request->has('sort') ? $input['sort'] : 1)
            ]);
            if (app()->getLocale() == 'en') {
                ProviderVacation::where('id', $input['id'])->update([
                    'certificate_name' => $input['certificate_name'],
                ]);
            } else {
                Translation::updateOrCreate([
                    'table_name' => 'provider_vacations',
                    'column_name' => 'certificate_name',
                    'foreign_key' => $data->id,
                    'locale' => 'ar',
                ], [
                    'value' => $input['certificate_name']
                ]);
            }
            return parent::sendSuccess(trans('messages.Data Updated!'), \App\Resources\ProviderVacation::make($data));
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

        $data = ProviderVacation::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderVacation::where([
                'id' => $request->id,
                'provider_id' => auth('sanctum')->user()->id
            ])->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

}
