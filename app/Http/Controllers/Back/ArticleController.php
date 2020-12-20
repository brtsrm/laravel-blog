<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\articleSeeder;
use App\Models\categorySeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = articleSeeder::orderBy("id", "DESC")->get();
        $data["articles"] = $articles;
        return view('back.articles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = categorySeeder::get();
        $data["categorys"] = $category;
        return view("back.articles.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:png,jpeg,jpg|max:2048',
        ]);

        $article = new articleSeeder;
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = str_slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . "." . $request->image->getClientOriginalExtension();
            $request->image->move(public_path("uploads"), $imageName);
            $article->image = "uploads/" . $imageName;
        }
        $article->save();
        toastr()->success('Makele başarlı şekilde oluşturuldu', 'Başarılı', ['timeOut' => 5000]);
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $article = articleSeeder::findOrFail($id);
        $data["article"] = $article;
        $category = categorySeeder::get();
        $data["categorys"] = $category;
        return view("back.articles.update", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:png,jpeg,jpg|max:2048',
        ]);

        $article = articleSeeder::findOrFail($id);
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->content;
        $article->slug = str_slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . "." . $request->image->getClientOriginalExtension();
            $request->image->move(public_path("uploads"), $imageName);
            $article->image = "uploads/" . $imageName;
        }
        $article->save();
        toastr()->success('Makele başarlı şekilde güncellendi', 'Başarılı', ['timeOut' => 5000]);
        return redirect()->route('admin.makaleler.index');
    }
    function switch (Request $request) {
            $article = articleSeeder::findOrFail($request->id);
            $article->status = $request->status == "true" ? 1 : 0;
            $article->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        articleSeeder::find($id)->delete();
        toastr()->success("Geri dönüşümü kutusuna gönderildi");
        return redirect()->route('admin.makaleler.index');
    }
    public function destroy($id)
    {
        return $id;
    }
    public function trashed()
    {
        $articles = articleSeeder::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $data['articles'] = $articles;
        return view('back.articles.trashed', $data);

    }
    public function recover($id)
    {
        articleSeeder::onlyTrashed()->find($id)->restore();
        toastr()->success("Makele geri dönüşümden çıkartıldı");
        return redirect()->back();

    }
    public function harddelete($id)
    {
        $article = articleSeeder::onlyTrashed()->find($id);
        if (FacadesFile::exists($article->image)) {
            FacadesFile::delete(public_path($article->image));
        }
        $article->forceDelete();
        toastr()->success("Makale kalıcı olarak silindi");
        return redirect()->route('admin.makaleler.index');
    }
}
