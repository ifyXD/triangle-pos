<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Upload\Entities\Upload;
use Modules\User\Rules\MatchCurrentPassword;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{

    public function edit()
    {
        return view('user::profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            // 'image' => [
            //     'required',
            //     'image',
            //     'mimes:jpeg,png,jpg,gif',
            //     'max:2048',
            //     Rule::dimensions()->maxWidth(300)->maxHeight(200), // Add dimension constraints if needed
            // ],
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        $user = User::find(auth()->user()->id);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image) {
                $oldImagePath = public_path($user->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image = $request->file('image');

            // Generate a unique filename
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Resize the image if needed
            // $resizedImage = Image::make($image)->resize(300, 200)->encode();

            // Store the image to the public directory with a unique filename
            $image->move(public_path('images/users'), $imageName);

            // Save the image path to the database or associate it with the user
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'image' => 'images/users/' . $imageName,
            ]);
        } else {
            // No image uploaded
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
        }

        // Handle other updates or redirects
        toast('Profile Updated!', 'success');
        return back();
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'  => ['required', 'max:255', new MatchCurrentPassword()],
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        toast('Password Updated!', 'success');

        return back();
    }
}
