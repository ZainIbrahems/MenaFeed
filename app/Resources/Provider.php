<?php

namespace App\Resources;

use App\Models\UserFollow;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class Provider extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $location = \App\Models\Provider::select(DB::raw('ST_Y(location) as y,ST_X(location) as x'))->
        where('id', $this->id)->first();
        $lat = $location && !is_null($location->y) ? $location->y : '25.2048';
        $lng = $location && !is_null($location->x) ? $location->x : '55.2708';
        $likes = 0;
        $followers = 0;
        $reviews_rate = 0;
        $reviews_count = 0;
        $distance = getProviderDistance($request, $location);
        $buttons = [
            [
                'type' => 'professionals',
                'title' => 'Professionals',
                'description' => 'Professionals work with us'
            ], [
                'type' => 'events',
                'title' => 'Events & Webinars',
                'description' => 'Learn more about ...'
            ], [
                'type' => 'appointments',
                'title' => 'Appointments',
                'description' => 'Learn more about ...'
            ], [
                'type' => 'marketplace',
                'title' => 'Marketplace',
                'description' => 'Learn more about ...'
            ], [
                'type' => 'e_services',
                'title' => 'E.Services',
                'description' => 'Learn more about ...'
            ], [
                'type' => 'departments',
                'title' => 'Departments',
                'description' => 'Learn more about ...'
            ], [
                'type' => 'videos',
                'title' => 'Videos for learn',
                'description' => 'Learn more about ...'
            ], [
                'type' => 'articles',
                'title' => 'Articles',
                'description' => 'Learn more about ...'
            ], [
                'type' => 'join_our_team',
                'title' => 'Join Our Team',
                'description' => 'Learn more about ...'
            ]
        ];
        $awards = [
            [
                'link' => '#',
                'image' => \Voyager::image(setting('admin.bg_image'))
            ],
            [
                'link' => '#',
                'image' => \Voyager::image(setting('admin.bg_image'))
            ],
            [
                'link' => '#',
                'image' => \Voyager::image(setting('admin.bg_image'))
            ],
            [
                'link' => '#',
                'image' => \Voyager::image(setting('admin.bg_image'))
            ]
        ];
        $reviews = [
            'total_size' => 100,
            'limit' => (int)10,
            'offset' => (int)1,
            'data' => [
                [
                    'image' => \Voyager::image(setting('admin.bg_image')),
                    'name' => 'User 1',
                    'date' => '2022-05-06',
                    'content' => 'content content content content content content content content',
                    'rate' => 1,
                ],
                [
                    'image' => \Voyager::image(setting('admin.bg_image')),
                    'name' => 'User 2',
                    'date' => '2022-05-06',
                    'content' => 'content content content content content content content content',
                    'rate' => 3,
                ], [
                    'image' => \Voyager::image(setting('admin.bg_image')),
                    'name' => 'User 3',
                    'date' => '2022-05-06',
                    'content' => 'content content content content content content content content',
                    'rate' => 5,
                ]
            ]
        ];
        $avg_rate = 5;
        $total_rates = 150;
        $locations = [
            [
                'id' => 1,
                'image' => getImageURL($this->personal_picture),
                'name' => $this->full_name,
                'phone' => $this->phone,
                'distance' => $distance,
                'lat' => strval($lat),
                'lng' => strval($lng)
            ]
        ];


        $is_following = false;
        if (auth('sanctum')->user()) {
            $is_following = (bool)UserFollow::where([
                'user_id' => auth('sanctum')->user()->id,
                'user_type' => getUserType(),
                'followed_id' => $this->id,
                'followed_type' => 'provider',
            ])->first();
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
            'is_live' => (int)$this->is_live,
            'platform' => Platform::make($this->platform),
            'category' => PlatformCategoryBref::collection($this->speciality_groups),
            'specialities_group' => PlatformSubCategoryBref::collection($this->speciality_groups),
            'specialities' => PlatformSubSubCategory::collection($this->specialities),
            'features' => Feature::collection($this->features),
            'more_data' => [
                'rawards' => ProviderAward::collection($this->awards->translate(app()->getLocale(), 'fallbackLocale')),
                'educations' => ProviderEducation::collection($this->educations->translate(app()->getLocale(), 'fallbackLocale')),
                'experiences' => ProviderExperience::collection($this->experiences->translate(app()->getLocale(), 'fallbackLocale')),
                'memberships' => ProviderMembership::collection($this->memberships->translate(app()->getLocale(), 'fallbackLocale')),
                'publications' => ProviderPublication::collection($this->publications->translate(app()->getLocale(), 'fallbackLocale')),
                'vacations' => ProviderVacation::collection($this->vacations->translate(app()->getLocale(), 'fallbackLocale')),
                'about' => $this->about,
                'points_cme' => \App\Models\ProvidersCme::where('provider_id',$this->id)->sum('points'),
                'locations' => $locations,
                'avg_rate' => $avg_rate,
                'total_rates' => $total_rates,
                'reviews' => $reviews,
                'buttons' => $buttons,
                'awards' => $awards,
            ]
        ];
    }

}
