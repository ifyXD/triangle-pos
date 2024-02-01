<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Setting;

class UserSettingController extends Controller
{

    public function index()
    {
        // abort_if(Gate::denies('access_settings'), 403);
        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            // If "Super Admin," retrieve all units
            $settings = Setting::where('user_id', $user->id)->first();
        } else {
            // If not "Super Admin," filter units by user_id
            $settings = Setting::where('user_id', $user->id)->first();
        }

        return view('setting::user-system-settings.index', compact('settings'));
    }
    public function update(Request $request)
    {
        $setting = Setting::where('user_id', $request->user_id)->first();


        if ($setting == null) {
            Setting::create([
                'company_name' => $request->company_name,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'notification_email' => $request->notification_email,
                'company_address' => $request->company_address,
                'default_currency_id' => $request->default_currency_id,
                'user_id' => auth()->user()->id,
                'default_currency_position' => $request->default_currency_position,
            ]);
        } else {
            $setting->update([
                'company_name' => $request->company_name,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'notification_email' => $request->notification_email,
                'company_address' => $request->company_address,
                'default_currency_id' => $request->default_currency_id,
                'user_id' => auth()->user()->id,
                'default_currency_position' => $request->default_currency_position,
            ]);
        }
        toast('Settings Updated!', 'info');

        return redirect()->route('system-settings.index');
    }
}
