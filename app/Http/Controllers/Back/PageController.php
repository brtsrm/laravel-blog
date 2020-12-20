<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\pageSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index()
    {
        $pages = pageSeeder::orderBy("order")->get();
        $data["pages"] = $pages;
        return view('back.pages.index', $data);
    }
    public function delete($id)
    {

        $pages = pageSeeder::find($id);
        if (File::exists($pages->image)) {
            File::delete(public_path($pages->image));
        }
        $pages->delete();
        toastr()->success("Sayfa silinmiştir");
        return redirect()->route('admin.page.index');

    }
    public function edit($id)
    {
        $page = pageSeeder::find($id);
        $data['pages'] = $page;
        return view('back.pages.update', $data);
    }
    public function editPage(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:png,jpeg,jpg|max:2048',
        ]);

        $pages = pageSeeder::findOrFail($id);
        $pages->title = $request->title;
        $pages->content = $request->content;
        $pages->slug = str_slug($request->title);
        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . "." . $request->image->getClientOriginalExtension();
            $request->image->move(public_path("uploads/page"), $imageName);
            $pages->image = "uploads/page/" . $imageName;
        }
        $pages->save();
        toastr()->success('Makele başarlı şekilde güncellendi', 'Başarılı', ['timeOut' => 5000]);
        return redirect()->route('admin.page.index');
    }
    public function create()
    {

        return view('back.pages.create');

    }
    public function createPage(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:png,jpeg,jpg|max:2048',
        ]);

        $lastOrder = pageSeeder::orderByDesc("order")->first();

        $page = new pageSeeder;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = str_slug($request->title);
        $page->order = $lastOrder->order + 1;
        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . "." . $request->image->getClientOriginalExtension();
            $request->image->move(public_path("uploads/page"), $imageName);
            $page->image = "uploads/page/" . $imageName;
        }
        $page->save();
        toastr()->success('Sayfa başarlı şekilde oluşturuldu');
        return redirect()->route('admin.page.index');
    }

    public function pageOrder(Request $request)
    {

        foreach ($request->get('page') as $key => $val) {
            pageSeeder::where('id', $val)->update(["order" => $key]);
        }
    }

    function switch (Request $request) {

            $page = pageSeeder::findOrFail($request->id);
            $page->statu = $request->status == "true" ? 1 : 0;
            $page->save();
    }
}
