<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogsFollow;
use App\Models\BlogsLike;
use App\Models\BlogsShare;
use App\Models\BlogView;
use App\Models\Provider;
use App\Models\ProviderFeed;
use App\Models\ProviderFeedLike;
use App\Models\UserFollow;
use App\Resources\BlogsBanner;
use App\Resources\BlogsCategory;
use App\Resources\ProviderBref;
use Carbon\Carbon;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use Validator;

class BlogsController extends Controller
{

    public function getInfo(Request $request)
    {
        $data = [];

        $banners = \App\Models\BlogsBanner::query();
        if ($request->has('platform_id') && is_numeric($request->get('platform_id'))) {
            $banners = $banners->where('platform_id', $request->get('platform_id'));
        }
        $banners = $banners->get();
        $data['banners'] = BlogsBanner::collection($banners);

        $categories = \App\Models\BlogsCategory::where('parent_id', NULL);
        if ($request->has('platform_id') && is_numeric($request->get('platform_id'))) {
            $categories = $categories->where('platform_id', $request->get('platform_id'));
        }
        $categories = $categories->get()->translate(app()->getLocale(), 'fallbackLocale');
        $data['categories'] = BlogsCategory::collection($categories);

        $top_articles = \App\Models\Blog::
        select('blogs.*', \DB::raw('count(*) as counter'))->
        join('blogs_views', 'blogs_views.blogs_id', '=', 'blogs.id');
        if ($request->has('platform_id') && is_numeric($request->get('platform_id'))) {
            $top_articles = $top_articles->whereIn('category_id',
                \App\Models\BlogsCategory::where('parent_id', NULL)->where('platform_id', $request->get('platform_id'))->pluck('id'));
        }
        $top_articles = $top_articles->skip(0)->groupBy('blogs.id')->
        orderBy('counter', 'desc')->take(10)->get();

        $data['top_articles'] = \App\Resources\Blog::collection($top_articles);


        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getAll(Request $request, $category_id = null)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;


        $data = Blog::query();

        if ($category_id != null && is_numeric($category_id)) {
            $data = $data
                ->where('category_id', $category_id)
                ->orWhere('sub_category_id', $category_id);
        }

        $data = $data->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $offset);

        $data = [
            'total_size' => $data->total(),
            'limit' => (int)$limit,
            'offset' => (int)$offset,
            'data' => \App\Resources\Blog::collection($data->all())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

    public function getDetails(Request $request, $id)
    {
        $blog = Blog::where('id', $id)->first();
        addBlogView($blog);
        return parent::sendSuccess(trans('messages.Data Got!'), $blog ? \App\Resources\Blog::make($blog) : null);
    }


    public function my($category_id = NULL)
    {


        $from_type = getUserType();
        $provider_id = auth('sanctum')->user()->id;
        $data = Blog::query();
        if ($from_type == 'provider') {
            $data = $data->where('provider_id', $provider_id);
        }

        if ($category_id != null && is_numeric($category_id)) {
            $data = $data
                ->where('category_id', $category_id)
                ->orWhere('sub_category_id', $category_id);
        }
        $data = $data->get();

        $blogs_count = Blog::where('provider_id', $provider_id)->count();
        $followers = UserFollow::
        where('followed_id', $provider_id)->
        where('followed_type', "provider")->
        count();
        $total_readers = BlogView::distinct()->select(['blogs.*'])->
        join('blogs', 'blogs.id', '=', 'blogs_views.blogs_id')->
        where('blogs.provider_id', $provider_id)->count();
        $total_shares = BlogsShare::select(['blogs.*'])->
        join('blogs', 'blogs.id', '=', 'blogs_share.blog_id')->
        where('blogs.provider_id', $provider_id)->count();
        $total_likes = BlogsLike::select(['blogs.*'])->
        join('blogs', 'blogs.id', '=', 'blogs_like.blog_id')->
        where('blogs.provider_id', $provider_id)->count();

        $provider = Provider::where('id', $provider_id)->first();

        $categories = \App\Models\BlogsCategory::where('parent_id', NULL);
        if ($provider && $provider->platform_id) {
            $categories = $categories->where('platform_id', $provider->platform_id);
        }
        $categories = $categories->get()->translate(app()->getLocale(), 'fallbackLocale');
        $categories = BlogsCategory::collection($categories);

        return parent::sendSuccess(trans('messages.Data Got!'), [
            'categories' => $categories,
            'total_shares' => $total_shares,
            'total_likes' => $total_likes,
            'total_readers' => $total_readers,
            'blogs_count' => $blogs_count,
            'followers' => $followers,
            'provider' => $provider ? ProviderBref::make($provider) : null,
            'data' => ($data ? \App\Resources\Blog::collection($data) : null)
        ]);
    }

    public function provider($provider_id, $category_id = NULL)
    {

        $data = Blog::where('provider_id', $provider_id);
        if ($category_id != null && is_numeric($category_id)) {
            $data = $data
                ->where('category_id', $category_id)
                ->orWhere('sub_category_id', $category_id);
        }
        $data = $data->get();

        $blogs_count = Blog::where('provider_id', $provider_id)->count();
        $followers = UserFollow::
        where('followed_id', $provider_id)->
        where('followed_type', "provider")->
        count();
        $total_readers = BlogView::distinct()->select(['blogs.*'])->
        join('blogs', 'blogs.id', '=', 'blogs_views.blogs_id')->
        where('blogs.provider_id', $provider_id)->count();
        $total_shares = BlogsShare::select(['blogs.*'])->
        join('blogs', 'blogs.id', '=', 'blogs_share.blog_id')->
        where('blogs.provider_id', $provider_id)->count();
        $total_likes = BlogsLike::select(['blogs.*'])->
        join('blogs', 'blogs.id', '=', 'blogs_like.blog_id')->
        where('blogs.provider_id', $provider_id)->count();


        $provider = Provider::where('id', $provider_id)->first();
        $categories = \App\Models\BlogsCategory::where('parent_id', NULL);
        if ($provider && $provider->platform_id) {
            $categories = $categories->where('platform_id', $provider->platform_id);
        }
        $categories = $categories->get()->translate(app()->getLocale(), 'fallbackLocale');
        $categories = BlogsCategory::collection($categories);

        return parent::sendSuccess(trans('messages.Data Got!'), [
            'categories' => $categories,
            'total_shares' => $total_shares,
            'total_likes' => $total_likes,
            'total_readers' => $total_readers,
            'blogs_count' => $blogs_count,
            'followers' => $followers,
            'provider' => $provider ? ProviderBref::make($provider) : null,
            'data' => ($data ? \App\Resources\Blog::collection($data) : null)
        ]);
    }

    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'banner' => 'required|image',
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $banner = '';
        if ($request->hasFile('banner')) {
            $slug = 'blogs';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->where('field', 'banner')->first();
            $banner = (new ContentImage($request, $slug, $row, $row->details))->handle();
        }

        $data = new Blog();
        $data->title = $request->get('title');
        $data->slug = slugify($request->get('title'));
        $data->content = $request->get('content');
        $data->category_id = $request->get('category_id');
        $data->sub_category_id = $request->has('sub_category_id') ? $request->get('sub_category_id') : NULL;
        $data->provider_id = auth('sanctum')->user()->id;
        $data->banner = $banner;
        $data->save();

        return parent::sendSuccess(trans('messages.Data Saved!'), $data ? \App\Resources\Blog::make($data) : null);
    }

    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $data = Blog::where('id', $request->get('id'))->first();
        $from_type = getUserType();
        $provider_id = auth('sanctum')->user()->id;
        if ($from_type == 'provider' && $provider_id == $data->provider_id) {
            Blog::where('id', $request->get('id'))->delete();
            return parent::sendSuccess(trans('messages.Data Deleted!'), null);
        }

        return parent::sendSuccess(trans('messages.Error in sent Data!'), null);
    }

    public function like(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $from_type = getUserType();

        $user_id = auth('sanctum')->user()->id;
        $data = BlogsLike::where([
            'user_id' => $user_id,
            'user_type' => $from_type,
            'blog_id' => $request->get('blog_id'),
        ])->first();
        if ($data) {
            $data->delete();

        } else {
            $data = new BlogsLike();
            $data->user_id = $user_id;
            $data->user_type = $from_type;
            $data->blog_id = $request->get('blog_id');
            $data->save();
        }

        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }

    public function share(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $blog = Blog::where('id', $request->blog_id)->first();

        if ($blog) {
            $from_type = getUserType();
            $user_id = auth('sanctum')->user()->id;

            $data = new BlogsShare();
            $data->user_id = $user_id;
            $data->user_type = $from_type;
            $data->blog_id = $request->get('blog_id');
            $data->save();


            return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\Blog::make($blog));
        }


        return parent::sendSuccess(trans('messages.Data Saved!'), null);
    }
}
