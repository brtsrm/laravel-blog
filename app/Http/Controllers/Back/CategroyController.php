<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\articleSeeder;
use App\Models\categorySeeder;
use Illuminate\Http\Request;

class CategroyController extends Controller
{
    public function index()
    {
        $category = categorySeeder::all();
        $data['categorys'] = $category;
        return view('back.categories.index', $data);
    }

    function switch (Request $request) {

            $article = categorySeeder::findOrFail($request->id);
            $article->status = $request->status == "true" ? 1 : 0;
            $article->save();
    }

    public function create(Request $request)
    {
        $isExists = categorySeeder::whereSlug(str_slug($request->name))->first();
        if ($isExists) {
            toastr()->warning("Ayni isiminden mevcut lütfen farklı bir isim giriniz");
            return redirect()->back();
        }
        $create = new categorySeeder;
        $create->name = $request->name;
        $create->slug = str_slug($request->name);
        $create->save();
        toastr()->success("başarılı şekilde kayıt edildi");
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $category = categorySeeder::findOrFail($request->id);
        return response()->json($category);
    }

    public function update(Request $request)
    {
        $isExists = categorySeeder::whereSlug(str_slug($request->slug))->whereNotIn('id', [$request->id])->first();
        $isName = categorySeeder::whereName($request->name)->whereNotIn('id', [$request->id])->first();
        if ($isExists or $isName) {
            toastr()->warning("Ayni isiminden mevcut lütfen farklı bir isim giriniz");
            return redirect()->back();
        }

        $create = categorySeeder::findOrFail($request->id);

        $create->name = $request->name;
        $create->slug = str_slug($request->name);
        $create->save();
        toastr()->success("Başarılı şekilde güncellendi");
        return redirect()->back();

    }

    public function delete(Request $request)
    {
        $category = categorySeeder::findOrFail($request->id);
        if ($category->id == 15) {
            toastr()->error("Bu kategoriyi silemezsin");
            return redirect()->back();
        }
        $mes = "";
        $articleCount = $category->articleCount();
        if ($articleCount > 0) {
            articleSeeder::where('category_id', $category->id)->update(['category_id' => 15]);
            $mes = "Bu kategoriye ait {$articleCount} kategorisine taşındı";
        }
        $category->delete();
        toastr()->success("Kategori başarlı şekilde silindi", $mes);
        return redirect()->back();
    }

}
