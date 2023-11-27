<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\ProviderEducation;
use App\Models\ProviderExperience;
use App\Models\ProviderPublication;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Translation;
use Validator;

class ProviderPublicationController extends Controller
{
    public function save(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'paper_title' => 'required|string',
            'publisher' => 'required|string',
            'published_url' => 'required|string',
            'published_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = new ProviderPublication();
        $data->provider_id = auth('sanctum')->user()->id;
        $data->paper_title = $request->get('paper_title');
        $data->summary = $request->get('summary');
        $data->publisher = $request->get('publisher');
        $data->published_url = $request->get('published_url');
        $data->published_date = $request->get('published_date');
        $data->sort = 1;
        $data->save();

        Translation::updateOrCreate([
            'table_name' => 'providers_publications',
            'column_name' => 'paper_title',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $input['paper_title']
        ]);

        Translation::updateOrCreate([
            'table_name' => 'providers_publications',
            'column_name' => 'summary',
            'foreign_key' => $data->id,
            'locale' => 'ar',
        ], [
            'value' => $request->get('summary')
        ]);

         Translation::updateOrCreate([
             'table_name' => 'providers_publications',
             'column_name' => 'publisher',
             'foreign_key' => $data->id,
             'locale' => 'ar',
         ], [
             'value' => $input['publisher']
         ]);

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProviderPublication::make($data));
    }

    public function edit(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'id' => 'required|numeric',
            'paper_title' => 'required|string',
            'publisher' => 'required|string',
            'published_url' => 'required|string',
            'published_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $data = ProviderPublication::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderPublication::where('id', $input['id'])->update([
                'published_url' => $input['published_url'],
                'published_date' => $input['published_date'],
                'sort' => ($request->has('sort') ? $input['sort'] : 1)
            ]);
            if (app()->getLocale() == 'en') {
                ProviderPublication::where('id', $input['id'])->update([
                    'paper_title' => $input['paper_title'],
                    'summary' => $request->get('summary'),
                    'publisher' => $input['publisher'],
                ]);
            } else {
                Translation::updateOrCreate([
                    'table_name' => 'providers_publications',
                    'column_name' => 'paper_title',
                    'foreign_key' => $data->id,
                    'locale' => 'ar',
                ], [
                    'value' => $input['paper_title']
                ]);

                Translation::updateOrCreate([
                    'table_name' => 'providers_publications',
                    'column_name' => 'summary',
                    'foreign_key' => $data->id,
                    'locale' => 'ar',
                ], [
                    'value' => $request->get('summary')
                ]);

                Translation::updateOrCreate([
                    'table_name' => 'providers_publications',
                    'column_name' => 'publisher',
                    'foreign_key' => $data->id,
                    'locale' => 'ar',
                ], [
                    'value' => $input['publisher']
                ]);
            }
            return parent::sendSuccess(trans('messages.Data Updated!'), \App\Resources\ProviderPublication::make($data));
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

        $data = ProviderPublication::where([
            'id' => $request->id,
            'provider_id' => auth('sanctum')->user()->id
        ])->first();
        if ($data) {
            ProviderPublication::where([
                'id' => $request->id,
                'provider_id' => auth('sanctum')->user()->id
            ])->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        } else {
            return parent::sendSuccess(trans('messages.Error in sent Data'), null);
        }
    }

}
