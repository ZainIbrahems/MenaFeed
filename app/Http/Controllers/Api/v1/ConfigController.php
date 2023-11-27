<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\AppointmentType;
use App\Models\Country;
use App\Models\HomeSection;
use App\Models\Language;
use App\Models\Platform;
use App\Models\PlatformCategory;
use App\Models\PlatformSubSubCategory;
use App\Models\ProviderFeedsTopic;
use App\Models\ProvidersSpecialities;
use App\Models\ProviderType;
use App\Resources\Banner;
use App\Models\PlatformSubCategory;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function start(Request $request)
    {
        $languages = \App\Resources\Language::collection(Language::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $countries = \App\Resources\Country::collection(Country::where('show_in_start', 1)->get()->translate(app()->getLocale(), 'fallbackLocale'));
        $platforms = \App\Resources\Platform::collection(Platform::
        orderBy('ranking', 'asc')->get()->translate(app()->getLocale(), 'fallbackLocale'));

        $appointment_types = \App\Resources\AppointmentType::collection(AppointmentType::get());
        $topics = \App\Resources\ProviderFeedsTopic::collection(ProviderFeedsTopic::get());

        return parent::sendSuccess(trans('messages.Data Got!'), [
            'topics' => $topics,
            'languages' => $languages,
            'platforms' => $platforms,
            'countries' => $countries,
            'appointment_types' => $appointment_types,
        ]);
    }

    public function countries(Request $request)
    {
        $countries = \App\Resources\Country::collection(Country::where('show_in_start', 1)->get()->translate(app()->getLocale(), 'fallbackLocale'));

        return parent::sendSuccess(trans('messages.Data Got!'), $countries);
    }

    public function platformsList(){
     $platforms =   Platform::all();

     return parent::sendSuccess(trans('messages.Data Got!'), $platforms);
    }

    public function categoriesList($provider_id,$platform_id){
        $categories = PlatformCategory::where('platform_id', $platform_id)->where('provider_type',$provider_id)->get();
        $categories = \App\Resources\PlatformCategory::collection($categories);
        return parent::sendSuccess(trans('messages.Data Got!'), $categories);
    }
    
    public function getSubCategories($category_id){
        $subCatgory = PlatformSubCategory::where('category_id',$category_id)->get();
        $subCatgory = \App\Resources\PlatformSubCategory::collection($subCatgory);
        
        return parent::sendSuccess(trans('messages.Data Got!'), $subCatgory);

    }

    public function getSubSubCategories($sub_category_id){
        $subCatgory = PlatformSubSubCategory::where('sub_category_id',$sub_category_id)->get();
        $subCatgory = \App\Resources\PlatformSubSubCategory::collection($subCatgory);
        
        return parent::sendSuccess(trans('messages.Data Got!'), $subCatgory);

    }
    public function getSpecialty($sub_category_id){
        
        $subCategory = PlatformSubCategory::with('subSubCategories')->find($sub_category_id);
        
        $specialties = [];
        $subsubcategories = [];
        $providerTypes = [];
        if($subCategory){
            foreach($subCategory->subSubCategories as $item){
                $providerType = ProvidersSpecialities::where('platform_sub_sub_category_id',$item->id)->pluck('provider_id');
                array_push($providerTypes,...$providerType);
                $subsubcategorie = ProvidersSpecialities::where('platform_sub_sub_category_id',$item->id)->whereIn('provider_id',$providerTypes)->pluck('platform_sub_sub_category_id');
                array_push($subsubcategories,...$subsubcategorie);
            }
            
            $subsubcategories = PlatformSubSubCategory::whereIn('id',$subsubcategories)->get();
            $specialties = $subsubcategories;
            return parent::sendSuccess(trans('messages.Data Got!'), $specialties);
        }
        return  parent::sendSuccess(trans('messages.Data Got!'), []);
        
    }

   
    public function providerTypes(){
        $providerTypes = ProviderType::all();
        return parent::sendSuccess(trans('messages.Data Got!'), $providerTypes);
        
    }
    public function categories(Request $request, $id)
    {
        $categories = PlatformCategory::where('platform_id', $id)->get();
        $categories = \App\Resources\PlatformCategory::collection($categories);
        return parent::sendSuccess(trans('messages.Data Got!'), $categories);
    }

    public function home_section(Request $request, $id)
    {
        $home_sections = HomeSection::where('platform_id', $id)->where('published', 'yes')->orderBy('position', 'asc')->get();
        $home_section_responses = [];
        foreach ($home_sections as $home_section) {
            $home_section_response['data']['video'] = null;
            $home_section_response['data']['categories'] = null;
            $home_section_response['data']['providers_nearby'] = null;
            $home_section_response['data']['providers_on_air'] = null;
            $home_section_response['data']['items'] = null;
            $home_section_response['data']['vacancies'] = null;
            $home_section_response['data']['deals'] = null;
            $home_section_response['data']['coupons'] = null;
            $home_section_response['data']['events'] = null;
            $home_section_response['data']['events_nearby'] = null;
            $home_section_response['data']['articles'] = null;
            $home_section_response['data']['talk'] = null;
            $home_section_response['data']['cme'] = null;
            $home_section_response['data']['banner'] = null;
            $home_section_response['data']['partner'] = null;
            $home_section_response['type'] = $home_section->home_section_type;
            $home_section_response['style'] = $home_section->design ? $home_section->design : '';
            $home_section_response['title'] = $home_section->title ? $home_section->title : '';
            switch ($home_section->home_section_type) {
                case 'video':
                    $video = $home_section->platform ? $home_section->platform->video : null;
                    $home_section_response['data']['video'] = getFileURL($video);
                    $home_section_response['data']['image'] = \Voyager::image(setting('admin.bg_image'));
                    if ($home_section_response['data']['video'] != '') {
                        $home_section_responses[] = $home_section_response;
                    }
                    break;
                case 'categories':
                    $category = \App\Models\PlatformCategory::select('platform_categories.*')->distinct()->
                    join('platform_categories_home_sections', 'platform_categories_home_sections.platform_category_id', '=', 'platform_categories.id')->
                    where('platform_categories_home_sections.home_section_id', $home_section->id)->get();
                    $home_section_response['data'] ['categories'] =
                        $category ? \App\Resources\PlatformCategory::collection($category) : null;
//                    if ($home_section->platform_category_id) {
//                        $cat = PlatformCategory::where('id', $home_section->platform_category_id)->first();
//                        $category = \App\Models\PlatformSubCategory::where('category_id', $home_section->platform_category_id)->get();
//                        $home_section_response['style'] = $cat ? $cat->design : '3_1';
//                        $home_section_response['data'] ['categories'] =
//                            $category ? \App\Resources\PlatformSubCategory::collection($category) : null;
//                    } else {
//                        $category = PlatformCategory::where('platform_id', $id)->get();
//                        $home_section_response['style'] = '3_1';
//                        $home_section_response['data'] ['categories'] =
//                            $category ? \App\Resources\PlatformCategory::collection($category) : null;
//                    }
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'providers_nearby':
                    $home_section_response['data']['providers_nearby'] = getProviderNearByHomeSection($request, $home_section);
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'providers_on_air':
                    $home_section_response['data']['providers_on_air'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'name' => 'Dr.Mohammed'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'name' => 'Dr.Mohammed'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'name' => 'Dr.Mohammed'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'name' => 'Dr.Mohammed'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'name' => 'Dr.Mohammed'
                        ]
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'items':
                    $home_section_response['data']['items'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test name",
                            'price' => '1700 AED'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test name",
                            'price' => '1700 AED'
                        ], ['id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test name",
                            'price' => '1700 AED'
                        ], ['id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test name",
                            'price' => '1700 AED'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test name",
                            'price' => '1700 AED'
                        ]
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'vacancies':
                    $home_section_response['data']['vacancies'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'location' => "Dubai - UAE",
                            'distance' => "18km",
                            'scope' => "test scope test scope test scope test scope test scope",
                            'created_at' => "2022-10-12"
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'location' => "Dubai - UAE",
                            'distance' => "18km",
                            'scope' => "test scope test scope test scope test scope test scope",
                            'created_at' => "2022-10-12"
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'location' => "Dubai - UAE",
                            'distance' => "18km",
                            'scope' => "test scope test scope test scope test scope test scope",
                            'created_at' => "2022-10-12"
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'location' => "Dubai - UAE",
                            'distance' => "18km",
                            'scope' => "test scope test scope test scope test scope test scope",
                            'created_at' => "2022-10-12"
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'location' => "Dubai - UAE",
                            'distance' => "18km",
                            'scope' => "test scope test scope test scope test scope test scope",
                            'created_at' => "2022-10-12"
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'location' => "Dubai - UAE",
                            'distance' => "18km",
                            'scope' => "test scope test scope test scope test scope test scope",
                            'created_at' => "2022-10-12"
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'location' => "Dubai - UAE",
                            'distance' => "18km",
                            'scope' => "test scope test scope test scope test scope test scope",
                            'created_at' => "2022-10-12"
                        ],
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'deals':
                    $home_section_response['data']['deals'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'distance' => "18km",
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'distance' => "18km",
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'distance' => "18km",
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'distance' => "18km",
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'distance' => "18km",
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'distance' => "18km",
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => "test title",
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'distance' => "18km",
                            'likes' => 220
                        ],
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'coupons':
                    $home_section_response['data']['coupons'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'description' => 'coupon details coupon details coupon details coupon details',
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'description' => 'coupon details coupon details coupon details coupon details',
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'description' => 'coupon details coupon details coupon details coupon details',
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'likes' => 220
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'description' => 'coupon details coupon details coupon details coupon details',
                            'price' => "300 AED",
                            'offer' => "30%",
                            'rate' => 4,
                            'likes' => 220
                        ]
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'events':
                    $home_section_response['data']['events'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'event title event title event title event title?',
                            'category' => "Biology",
                            'user_img' => \Voyager::image(setting('admin.bg_image')),
                            'user_name' => 'Dr.Fadi Name',
                            'duration' => "02 h 30 min",
                            'type' => "online",
                            'date' => "August 05,2022",
                            'time' => "02:00 pm",
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'event title event title event title event title?',
                            'category' => "Biology",
                            'user_img' => \Voyager::image(setting('admin.bg_image')),
                            'user_name' => 'Dr.Fadi Name',
                            'duration' => "02 h 30 min",
                            'type' => "online",
                            'date' => "August 05,2022",
                            'time' => "02:00 pm",
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'event title event title event title event title?',
                            'category' => "Biology",
                            'user_img' => \Voyager::image(setting('admin.bg_image')),
                            'user_name' => 'Dr.Fadi Name',
                            'duration' => "02 h 30 min",
                            'type' => "online",
                            'date' => "August 05,2022",
                            'time' => "02:00 pm",
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'event title event title event title event title?',
                            'category' => "Biology",
                            'user_img' => \Voyager::image(setting('admin.bg_image')),
                            'user_name' => 'Dr.Fadi Name',
                            'duration' => "02 h 30 min",
                            'type' => "online",
                            'date' => "August 05,2022",
                            'time' => "02:00 pm",
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'event title event title event title event title?',
                            'category' => "Biology",
                            'user_img' => \Voyager::image(setting('admin.bg_image')),
                            'user_name' => 'Dr.Fadi Name',
                            'duration' => "02 h 30 min",
                            'type' => "online",
                            'date' => "August 05,2022",
                            'time' => "02:00 pm",
                        ]
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'events_nearby':
                    $home_section_response['data']['events_nearby'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.21048',
                            'lng' => '55.27108'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.20548',
                            'lng' => '55.24708'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.20548',
                            'lng' => '55.27508'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.26048',
                            'lng' => '55.27608'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.220428',
                            'lng' => '55.27708'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.220428',
                            'lng' => '55.27208'
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'distance' => '1.7km',
                            'lat' => '25.230438',
                            'lng' => '55.23708'
                        ]
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'articles':
                    $home_section_response['data']['articles'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'Article Title',
                            'category' => 'health',
                            'created_at' => '02/08/2022',
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'Article Title',
                            'category' => 'health',
                            'created_at' => '02/08/2022',
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'Article Title',
                            'category' => 'health',
                            'created_at' => '02/08/2022',
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'Article Title',
                            'category' => 'health',
                            'created_at' => '02/08/2022',
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'Article Title',
                            'category' => 'health',
                            'created_at' => '02/08/2022',
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'title' => 'Article Title',
                            'category' => 'health',
                            'created_at' => '02/08/2022',
                        ],
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'talk':
                    $home_section_response['data']['talk'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ],
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => asset('mov_bbb.mp4')
                        ]
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'cme':
                    $home_section_response['data']['cme'] = [
                        [
                            'id' => 1,
                            'title' => 'CME Title CME Title CME Title CME Title CME Title CME Title?',
                            'date' => 'August 05, 2022',
                            'distance' => '30km',
                            'description' => 'CME description, CME description CME description CME description CME description',
                            'logos' => [
                                \Voyager::image(setting('admin.bg_image')),
                                \Voyager::image(setting('admin.bg_image')),
                            ],
                            'time' => '02 h 30 m',
                            'reviews' => 4.5
                        ],
                        [
                            'id' => 1,
                            'title' => 'CME Title CME Title CME Title CME Title CME Title CME Title?',
                            'date' => 'August 05, 2022',
                            'distance' => '30km',
                            'description' => 'CME description, CME description CME description CME description CME description',
                            'logos' => [
                                \Voyager::image(setting('admin.bg_image')),
                                \Voyager::image(setting('admin.bg_image')),
                            ],
                            'time' => '02 h 30 m',
                            'reviews' => 4.5
                        ],
                        [
                            'id' => 1,
                            'title' => 'CME Title CME Title CME Title CME Title CME Title CME Title?',
                            'date' => 'August 05, 2022',
                            'distance' => '30km',
                            'description' => 'CME description, CME description CME description CME description CME description',
                            'logos' => [
                                \Voyager::image(setting('admin.bg_image')),
                                \Voyager::image(setting('admin.bg_image')),
                            ],
                            'time' => '02 h 30 m',
                            'reviews' => 4.5
                        ],
                        [
                            'id' => 1,
                            'title' => 'CME Title CME Title CME Title CME Title CME Title CME Title?',
                            'date' => 'August 05, 2022',
                            'distance' => '30km',
                            'description' => 'CME description, CME description CME description CME description CME description',
                            'logos' => [
                                \Voyager::image(setting('admin.bg_image')),
                                \Voyager::image(setting('admin.bg_image')),
                            ],
                            'time' => '02 h 30 m',
                            'reviews' => 4.5
                        ],
                        [
                            'id' => 1,
                            'title' => 'CME Title CME Title CME Title CME Title CME Title CME Title?',
                            'date' => 'August 05, 2022',
                            'distance' => '30km',
                            'description' => 'CME description, CME description CME description CME description CME description',
                            'logos' => [
                                \Voyager::image(setting('admin.bg_image')),
                                \Voyager::image(setting('admin.bg_image')),
                            ],
                            'time' => '02 h 30 m',
                            'reviews' => 4.5
                        ],
                        [
                            'id' => 1,
                            'title' => 'CME Title CME Title CME Title CME Title CME Title CME Title?',
                            'date' => 'August 05, 2022',
                            'distance' => '30km',
                            'description' => 'CME description, CME description CME description CME description CME description',
                            'logos' => [
                                \Voyager::image(setting('admin.bg_image')),
                                \Voyager::image(setting('admin.bg_image')),
                            ],
                            'time' => '02 h 30 m',
                            'reviews' => 4.5
                        ],
                        [
                            'id' => 1,
                            'title' => 'CME Title CME Title CME Title CME Title CME Title CME Title?',
                            'date' => 'August 05, 2022',
                            'distance' => '30km',
                            'description' => 'CME description, CME description CME description CME description CME description',
                            'logos' => [
                                \Voyager::image(setting('admin.bg_image')),
                                \Voyager::image(setting('admin.bg_image')),
                            ],
                            'time' => '02 h 30 m',
                            'reviews' => 4.5
                        ]
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'banner':
                    $home_section_response['data']['banner'] = Banner::collection(
                        \App\Models\Banner::where('home_section_id', $home_section->id)->get());
                    $home_section_responses[] = $home_section_response;
                    break;
                case 'partner':
                    $home_section_response['data']['partner'] = [
                        [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => '#'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => '#'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => '#'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => '#'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => '#'
                        ], [
                            'id' => 1,
                            'image' => \Voyager::image(setting('admin.bg_image')),
                            'url' => '#'
                        ],
                    ];
                    $home_section_responses[] = $home_section_response;
                    break;
            }
        }
        return parent::sendSuccess(trans('messages.Data Got!'), $home_section_responses);
    }

    public function chatGPT(Request $request)
    {
        return parent::sendSuccess(trans('messages.Data Got!'), [
            'key'=>'ewldhdqwewWHEIUWDdqwiwdhiH@(HD@d2'
        ]);
    }
}
