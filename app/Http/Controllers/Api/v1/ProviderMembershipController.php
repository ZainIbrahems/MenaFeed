<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\ProviderMembership;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Translation;
use Validator;

class ProviderMembershipController extends Controller
{
    public function save(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
            'authority_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = new ProviderMembership();
        $data->provider_id = auth('sanctum')->user()->id;
        $data->name = $input['name'];
        $data->authority_name = $request->get('authority_name');
        $data->sort = 1;
        $data->save();


        Translation::updateOrCreate([
            'table_name' => 'provider_membership',
            'column_name' => 'name',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $input['name']
        ]);


        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderMembership::make($data));
    }

    public function edit(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'authority_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderMembership::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderMembership::where('id', $input['id'])->update([
                'authority_name' => $input['authority_name'],
                'sort' => ($request->has('sort') ? $input['sort'] : 1)
            ]);
            if (app()->getLocale() == 'en') {
                ProviderMembership::where('id', $input['id'])->update([
                    'name' => $input['name']
                ]);
            } else {

                Translation::updateOrCreate([
                    'table_name' => 'provider_membership',
                    'column_name' => 'name',
                    'foreign_key' => $data->id,
                    'locale' => 'ar',
                ], [
                    'value' => $input['name']
                ]);

            }
            return parent::sendSuccess(trans('messages.Data Updated!'), \App\Resources\ProviderMembership::make($data));
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

        $data = ProviderMembership::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderMembership::where([
                'id' => $request->id,
                'provider_id' => auth('sanctum')->user()->id
            ])->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

}
