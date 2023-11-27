<?php

namespace App\Resources;

use App\Models\ProvidersProfessional;
use App\Models\UserFollow;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderBrefAppointment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $location = \App\Models\Provider::select(DB::raw('ST_Y(location) as y,ST_X(location) as x'))->where('id', $this->id)->first();
        $lat = $location && !is_null($location->y) ? $location->y : '25.2048';
        $lng = $location && !is_null($location->x) ? $location->x : '55.2708';
        $likes = 0;
        $followers = 0;
        $reviews_rate = 0;
        $reviews_count = 0;
        $is_following = false;
        if (auth('sanctum')->user()) {
            $is_following = (bool)UserFollow::where([
                'user_id' => auth('sanctum')->user()->id,
                'user_type' => getUserType(),
                'followed_id' => $this->id,
                'followed_type' => 'provider',
            ])->first();
        }
        $distance = getProviderDistance($request, $location);


        $facilities = [];
        $provider_prof = ProvidersProfessional::where('professional_id', $this->id)->get();
        foreach ($provider_prof as $pr) {
            if ($pr->provider) {
                $facilities[] = [
                    'id' => $pr->provider->name,
                    'full_name' => $pr->provider->full_name,
                ];
            }
        }

        return [
            'id' => (int)$this->id,
            'personal_picture' => $this->personal_picture ? getImageURL($this->personal_picture) : \Voyager::image(setting('admin.bg_image')),
            'full_name' => $this->full_name,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_verified_at' => $this->phone_verified_at,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
            'role_id' => 2,
            'role_name' => 'provider',
            'recovery_email' => $this->recovery_email,
            'website' => $this->website,
            'fax' => $this->fax,
            'whatsapp' => $this->whatsapp,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'tiktok' => $this->tiktok,
            'youtube' => $this->youtube,
            'linkedin' => $this->linkedin,
            'provider_type_fields' => $this->provider_type_fields,
            'address' => $this->address,
            'qualification_certificate' => getFileURL($this->qualification_certificate),
            'professional_license' => getFileURL($this->professional_license),
            'abbreviation' => Abbreviation::make($this->abbreviation),
            'expertise' => $this->expertise,
            'summary' => $this->summary,
            'subscription' => SubscriptionType::make($this->subscription),
            'registration_number' => $this->registration_number,
            'lat' => strval($lat),
            'lng' => strval($lng),
            'likes' => $likes,
            'followers' => $followers,
            'reviews_rate' => $reviews_rate,
            'reviews_count' => $reviews_count,
            'is_following' => $is_following,
            'distance' => $distance,
            'verified' => (int)$this->verified,
            'platform' => Platform::make($this->platform),
            'category' => PlatformCategoryBref::collection($this->speciality_groups),
            'specialities_group' => PlatformSubCategoryBref::collection($this->speciality_groups),
            'specialities' => PlatformSubSubCategory::collection($this->specialities),
            'features' => Feature::collection($this->features),
            'facilities' => $facilities,
        ];
    }
}
