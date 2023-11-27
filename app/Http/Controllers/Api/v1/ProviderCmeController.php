<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\ProviderEducation;
use App\Models\ProviderExperience;
use App\Models\ProvidersCme;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Translation;
use Validator;

class ProviderCmeController extends Controller
{
    public function save(Request $request)
    {
        $input = request()->all();

        $validator = Validator::make($input, [
            'title' => 'required|string',
            'source_type' => 'required|string',
            'start_year' => 'required',
            'end_year' => 'required',
            'cme_accredited_by' => 'required|string',
            'points' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError([['message' => trans('messages.Error in sent Data!')]], 404);
        }

        $certificate = '';
        if ($request->hasFile('certificate')) {
            $slug = 'providers-cme';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'image')->first();
            $certificate = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }

        $data = new ProvidersCme();
        $data->provider_id = auth('sanctum')->user()->id;
        $data->title = $input['title'];
        $data->source_type = $input['source_type'];
        $data->start_year = $input['start_year'];
        $data->end_year = $request->get('end_year');
        $data->cme_accredited_by = $request->get('cme_accredited_by');
        $data->points = $request->get('points');
        $data->certificate = $certificate;
        $data->save();


        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\ProvidersCme::make($data));
    }

}
