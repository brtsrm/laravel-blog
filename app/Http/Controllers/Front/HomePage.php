<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\articleSeeder;
use App\Models\categorySeeder;
use App\Models\Configs;
use App\Models\pageSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomePage extends Controller
{
    public function __construct()
    {
        if(Configs::find(1)->active == 0){
            return redirect()->to("site-bakimda")->send();
        }
        view()->share('pages', pageSeeder::where('statu',1)->orderBy('order', 'ASC')->get());
    }
    public function index()
    {
        $data["articles"] = articleSeeder::with('getCategory')->where('status','1')->whereHas('getCategory',function($query){
            $query->where("status",1);
        })->orderBy('id', 'DESC')->paginate(10);
        $data["articles"]->withPath(url("sayfa"));
        $data["categorys"] = categorySeeder::where('status',1)->inRandomOrder()->get();
        return view("fronts.homepage", $data);
    }
    public function single($category, $slug)
    {
        $category = categorySeeder::whereSlug($category)->first() ?? abort(404, "Böyle Bir makale bulunamadı");
        $article = articleSeeder::where('slug', '=', $slug)->get()->first() ?? abort(404, "Böyle Bir yazı bulun");
        $article->increment('hit');
        $data["article"] = $article;
        $data["categorys"] = categorySeeder::where('status',1)->inRandomOrder()->get();
        return view("fronts.single", $data);
    }
    public function category($slug)
    {

        $category = categorySeeder::whereSlug($slug)->first() ?? abort(404, "böyle bir makele bulunamadı");
        $data["category"] = $category;
        $data["categorys"] = categorySeeder::where('status',1)->inRandomOrder()->get();
        $data["articles"] = articleSeeder::where("category_id", $category->id)->where('status',1)->paginate(1);

        return view('fronts.category', $data);
    }

    public function page($slug)
    {

        $page = pageSeeder::where("slug", $slug)->first() ?? abort(404, "Sayfa bulunamadı");
        $data["page"] = $page;
        return view("fronts.page", $data);

    }
    public function contact()
    {
        return view("fronts.iletisim");
    }
    public function contactPost(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|min:10',
            'message' => 'required|min:10',
        ];

        $validate = Validator::make($request->post(), $rules);

      
        Mail::raw($request->message, function ($message) use ($request) {

            $message->from('doqtor9101@gmail.com', config('app.name'));
            $message->to('doqtor9101@gmail.com');
            $message->subject($request->name . ' Kişi mesajı gönderdi ');
            
        });
        
        return redirect()->route("contact")->with("success", "Mesajınız başarılı şekilde iletilmiştir.");
        // $contactModel = new contactSeed;
        // $contactModel->name = $request->name;
        // $contactModel->email = $request->email;
        // $contactModel->phone = $request->phone ?? 0;
        // $contactModel->message = $request->message;
        // $contactModel->save();


    }
}
