<?php

namespace App\Resources;

use App\Models\UsersField;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class PlatformUserInput extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $value = NULL;

        if (auth('sanctum')->check()) {
            $uf = UsersField::where([
                'field_id' => $this->id,
                'user_id' => auth('sanctum')->user()->id
            ])->first();
            if ($uf) {
                if ($this->type == 'file') {
                    $value = getImageURL($uf->value);
                } else {
                    $value = $uf->value;
                }
            }
        }

        $extensions = [];
        foreach ($this->extensions as $ex) {
            $extensions[] = $ex->name;
        }

        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
            'required' => $this->required,
            'extensions' => $extensions,
            'type' => $this->type,
            'value' => $value,
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString()
        ];
    }
}
