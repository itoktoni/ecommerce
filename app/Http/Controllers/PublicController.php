<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Helper;
use App;
use DB;
use App\Enums\OptionSlider;
use Modules\Item\Dao\Repositories\BrandRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Marketing\Dao\Models\Slider;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Marketing\Dao\Repositories\SliderRepository;
use Modules\Marketing\Dao\Repositories\SosmedRepository;

class PublicController extends Controller
{

    public function __construct()
    {
        view()->share('public_category', Helper::createOption((new CategoryRepository()), false, true, true));
        view()->share('public_sosmed', Helper::createOption((new SosmedRepository()), false, true, true));
    }

    public function index($slider = false)
    {
        if ($slider) {
            $model = new SliderRepository();
            $data = $model->slugRepository($slider);
            return View(Helper::setViewFrontend('page'))->with([
                'title' => $data->marketing_slider_name,
                'description' => $data->marketing_slider_description,
                'image' => Helper::files('slider/' . $data->marketing_slider_image),
                'page' => $data->marketing_slider_page,
                'link' => $data->marketing_slider_link,
            ]);
        }

        $default_slider = Helper::createOption(new SliderRepository(), false, true);
        return view(Helper::setViewFrontend(__FUNCTION__))->with([
            'slider' => $default_slider
        ]);
    }

    public function about()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function shop()
    {
        $color = Helper::createOption(new ColorRepository(), false, true)->pluck('item_color_code');
        $size = Helper::createOption(new SizeRepository(), false, true)->pluck('item_size_code');
        $tag = Helper::createOption(new TagRepository(), false, true)->pluck('item_tag_slug');
        $brand = Helper::createOption(new BrandRepository(), false, true)->pluck('item_brand_slug', 'item_brand_name');
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'color' => $color,
            'size' => $size,
            'tag' => $tag,
            'brand' => $brand,
        ]);
    }

    public function faq()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function promo($slug = false)
    {
        if ($slug) {
            $model = new PromoRepository();
            $data = $model->slugRepository($slug);
            return View(Helper::setViewFrontend('page'))->with([
                'title' => $data->marketing_promo_name,
                'description' => $data->marketing_promo_description,
                'image' => Helper::files('promo/' . $data->marketing_promo_image),
                'page' => $data->marketing_promo_page,
                'link' => '',
            ]);
        }

        $promo = Helper::createOption(new PromoRepository(), false, true);
        $single = $promo->where('marketing_promo_default', 1)->first();
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'promo' => $promo->whereNotIn('marketing_promo_default', [1])->all(),
            'single' => $single,
        ]);
    }

    public function category($slug = false)
    {
        if ($slug) { }

        return View(Helper::setViewFrontend(__FUNCTION__));
    }

    public function cart()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function checkout()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }


    public function contact()
    {
        if (request()->isMethod('POST')) {

            $data = [
                'email' => request()->get('email'),
                'name' => request()->get('name'),
                'header' => 'Notification Information From Customer',
                'desc' => request()->get('desc'),
            ];

            $from = request()->get('email');
            $name = request()->get('name');

            $request = request()->all();
            $request['message'] = request()->get('desc');
            $contact = new App\Contact();
            $contact->simpan($request);

            $this->validate(request(), [
                'email' => 'email|required',
                'name'  => 'required',
                'desc' => 'required',
            ]);
            try {
                $test = Mail::send('emails.contact', $data, function ($message) use ($from, $name) {
                    $message->to(config('mail.from.address'), config('mail.from.name'));
                    $message->subject('Notification Information From Customer');
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                });
            } catch (Exception $e) {
                // return Response::redirectBack();;
            }

            return Response::redirectBack();;
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function install()
    {

        if (request()->isMethod('POST')) {

            $file = DotenvEditor::load('local.env');
            $file->setKey('DB_CONNECTION', request()->get('provider'));
            $file->setKey('DB_HOST', request()->get('host'));
            $file->setKey('DB_DATABASE', request()->get('database'));
            $file->setKey('DB_USERNAME', request()->get('username'));
            $file->setKey('DB_PASSWORD', request()->get('password'));
            $file->save();
            // dd(request()->get('provider'));
            $value = DotenvEditor::getValue('DB_CONNECTION');
            // dd($value);
            $file = DotenvEditor::setKey('DB_CONNECTION', request()->get('provider'));
            $file = DotenvEditor::save();
            // Config::write('database.connections', request()->get('provider'));
            dd(request()->all());
        }
        // rename(base_path('readme.md'), realpath('').'readme.md');
        return View('welcome');
    }

    public function cara_belanja()
    {
        return View('frontend.' . config('website.frontend') . '.pages.cara_belanja');
    }

    public function marketing()
    {
        $site = new \App\Site();
        $user = DB::table('users')->where('group_user', '=', 'sales')->get();
        return View('frontend.' . config('website.frontend') . '.pages.marketing')->with([
            'site' => $site->all(),
            'user' => $user,
        ]);;
    }

    public function konfirmasi()
    {
        if (request()->isMethod('POST')) {

            dd(request()->all());
        }
        return View('frontend.' . config('website.frontend') . '.pages.konfirmasi');
    }

    public function product()
    {
        $product = new \App\Product();

        return View('frontend.' . config('website.frontend') . '.pages.product')->with([
            'product' => $product->baca()->Where('active', '!=', 0)->get(),
        ]);
    }

    public function solution()
    {
        $solution = new \App\Solution();

        return View('frontend.' . config('website.frontend') . '.pages.solution')->with([
            'solution' => $solution->baca()->get(),
        ]);
    }

    public function detail($slug)
    {

        if (!empty($slug)) {
            $data = DB::table('products')
                ->select(['products.*', 'category.name as categoryName'])
                ->leftJoin('category', 'category.id', 'products.category_id')
                ->where('products.slug', $slug)->first();
            return View('frontend.' . config('website.frontend') . '.pages.detail')->with([
                'data' => $data,
                'category' => Helper::createOption('category-api'),
                'tag' => Helper::createOption('tag-api'),
            ]);
        }
    }

    public function single($id)
    {
        if (!empty($id)) {
            $product = new \App\Product();
            $data = $product->getStock($id)->first();
            return View('frontend.' . config('website.frontend') . '.pages.single')->with('data', $data);
        }
    }

    public function segment($id)
    {
        $segmentasi = new \App\Segmentasi();
        $category = new \App\Category();
        $material = new \App\Material();
        if (!empty($id)) {
            $product = new \App\Product();
            $data = $product->segment($id)->paginate(6);
            return View('frontend.' . config('website.frontend') . '.pages.catalog')->with([
                'product' => $data,
                'segmentasi' => $segmentasi->baca()->get(),
                'category' => $category->baca()->get(),
                'material' => $material->baca()->get(),
            ]);
        }
    }
}
