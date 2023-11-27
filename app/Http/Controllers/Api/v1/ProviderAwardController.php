<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\ProviderAward;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Translation;
use Validator;

class ProviderAwardController extends Controller
{
    public function save(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'title' => 'required|string',
            'year' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = new ProviderAward();
        $data->provider_id = auth('sanctum')->user()->id;
        $data->title = $input['title'];
        $data->authority_name = $request->get('authority_name');
        $data->year = $input['year'];
        $data->sort = 1;
        $data->save();


        Translation::updateOrCreate([
            'table_name' => 'provider_awards',
            'column_name' => 'title',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $input['title']
        ]);

        Translation::updateOrCreate([
            'table_name' => 'provider_awards',
            'column_name' => 'authority_name',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' =>$request->get('authority_name')?$request->get('authority_name'):''
        ]);

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderAward::make($data));
    }

    public function edit(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
            'title' => 'required|string',
            'year' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderAward::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderAward::where('id', $input['id'])->update([
                'year' => $input['year'],
                'sort' => ($request->has('sort') ? $input['sort'] : 1)
            ]);
            if (app()->getLocale() == 'en') {
                ProviderAward::where('id', $input['id'])->update([
                    'title' => $input['title'],
                    'authority_name' => $request->get('authority_name')
                ]);
            } else {
                Translation::updateOrCreate([
                    'table_name' => 'provider_awards',
                    'column_name' => 'title',
                    'foreign_key' => $data->id,
                    'locale' => 'ar',
                ], [
                    'value' => $input['title']
                ]);

                Translation::updateOrCreate([
                    'table_name' => 'provider_awards',
                    'column_name' => 'authority_name',
                    'foreign_key' => $data->id,
                    'locale' => 'ar',
                ], [
                    'value' =>$request->get('authority_name')?$request->get('authority_name'):''
                ]);
            }
            return parent::sendSuccess(trans('messages.Data Updated!'), \App\Resources\ProviderAward::make($data));
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

        $data = ProviderAward::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderAward::where([
                'id' => $request->id,
                'provider_id' => auth('sanctum')->user()->id
            ])->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

}
