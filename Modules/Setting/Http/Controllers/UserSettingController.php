<?php

namespace Modules\Setting\Http\Controllers;

use App\Models\Store;
use App\Models\ThemeSetting;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Setting;
use Illuminate\Support\Facades\Storage;

class UserSettingController extends Controller
{

    public function index()
    {
        // abort_if(Gate::denies('access_settings'), 403);
        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            // If "Super Admin," retrieve all units
            $settings = Setting::where('user_id', $user->store->id)->first();
        } else {
            // If not "Super Admin," filter units by user_id
            $settings = Setting::where('user_id', auth()->user()->store->id)
            ->where('user_id', auth()->user()->id)
            ->first();
     $userpermissions = UserPermission::where('user_id', $user->id)->orderBy('id', 'asc')->get();

        }



        return view('setting::user-system-settings.index', compact('settings','userpermissions'));
    }
    public function update(Request $request)
    {
        $setting = Store::where('user_id', $request->user_id)->first();
    
        // If no existing setting is found, return an error or create a new setting
        if (!$setting) {
            // Option 1: Create a new setting
            $setting = Store::create([
                'store_name' => $request->store_name,
                'store_email' => $request->store_email,
                'store_phone' => $request->store_phone,
                'store_address' => $request->store_address,
                'user_id' => auth()->user()->id,
                'image' => $request->hasFile('image') ? $request->file('image')->store('images/stores/user', 'public') : 'avatar.png',
            ]);
        } else {
            // Handle image upload and deletion
            if ($request->hasFile('image')) {
                // If an image is uploaded, save it to the public/images/settings/user directory
                $imagePath = $request->file('image')->store('images/stores/user', 'public');
    
                // Delete the previous image (if any)
                if ($setting->image) {
                    Storage::disk('public')->delete($setting->image);
                }
                $setting->image = $imagePath;
            }
    
            // Update existing setting
            $setting->update([
                'store_name' => $request->store_name,
                'store_email' => $request->store_email,
                'store_phone' => $request->store_phone,
                'store_address' => $request->store_address,
                'user_id' => auth()->user()->id,
                'image' => isset($imagePath) ? $imagePath : $setting->image,
            ]);
        }
    
        toast('Settings Updated!', 'info');
    
        return redirect()->route('system-settings.index');
    }
    
    public function themeupdate(Request $request)
    {
        $setting = ThemeSetting::where('user_id', $request->user_id)->first();


        if ($setting == null) {
            ThemeSetting::create([
                'sidebar_color' => $request->sidebar_color,
                'user_id' => auth()->user()->id,
            ]);
        } else {
            $setting->update([
                'sidebar_color' => $request->sidebar_color,
                'user_id' => auth()->user()->id,
            ]);
        }
        toast('Settings Updated!', 'info');

        return redirect()->route('system-settings.index');
    }
}
