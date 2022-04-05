<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestSetting;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::limit(1)->get();
        return view('admin.setting.index', compact('settings'));
    }

    public function edit($id)
    {
        $setting = Setting::find($id);
        if(empty($setting))
        {
            return redirect()->back()->with('error', 'Cấu hình không tồn tại !');
        }
        return view('admin.setting.edit', compact('setting'));
    }

    public function update(RequestSetting $request, $id)
    {
        $data = $request->except("_token");

        // get request Favicon
        if ($request->hasFile('favicon')){
            $extensionFavicon = $request->favicon->extension();
            $filenameFavicon = 'settings-' . uniqid() . '.' . $extensionFavicon;
            $data['favicon'] = $request->favicon->storeAs('settings', $filenameFavicon, 'public');
        }

        // get request Logo
        if ($request->hasFile('logo')) {
            $extensionLogo = $request->logo->extension();
            $filenameLogo = 'settings-' . uniqid() . '.' . $extensionLogo;
            $data['logo'] = $request->logo->storeAs('settings', $filenameLogo, 'public');
        }

        // get request banner
        if ($request->hasFile('banner')) {
            $extensionBanner = $request->banner->extension();
            $filenameBanner = 'settings-' . uniqid() . '.' . $extensionBanner;
            $data['banner'] = $request->banner->storeAs('settings', $filenameBanner, 'public');
        }

        // get request banner home
        if ($request->hasFile('banner_home')) {
            $extensionBannerHome = $request->banner_home->extension();
            $filenameBannerHome = 'settings-' . uniqid() . '.' . $extensionBannerHome;
            $data['banner_home'] = $request->banner_home->storeAs('settings', $filenameBannerHome, 'public');
        }

        Setting::find($id)->update($data);

        return redirect()->route('get.setting.index')->with('success', 'Cập nhật cấu hình thành công !');
    }
}
