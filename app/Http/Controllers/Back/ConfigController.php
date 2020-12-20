<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Configs;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    public function index()
    {
        $config = Configs::find(1);
        $data["config"] = $config;
        return view('back.config.index', $data);
    }

    public function updateSetting(Request $request)
    {
        $config = Configs::find(1);
        $config->title = $request->site_title;
        $config->active = ($request->site_durumu == "on") ? 1 : 0;
        if ($request->hasFile('site_favicon')) {
            $faviconName = str_slug($request->site_title) . "1." . $request->site_favicon->getClientOriginalExtension();
            $request->site_favicon->move(public_path("uploads/setting"), $faviconName);
            $config->favicon = "uploads/setting/" . $faviconName;

        }
        if ($request->hasFile('site_logo')) {
            $logoName = str_slug($request->site_title) . "2." . $request->site_logo->getClientOriginalExtension();
            $request->site_logo->move(public_path("uploads/setting"), $logoName);
            $config->logo = "uploads/setting/" . $logoName;
        }
        $config->linkedin = $request->site_linkedin;
        $config->github = $request->site_github;
        $config->description = $request->site_aciklamasi;
        $config->save();

        toastr("Başarılı şekilde güncellendi");
        return redirect()->back();
    }

}
