<?php

namespace Modules\User\Http\Controllers;

use Modules\User\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Upload\Entities\Upload; 
use Illuminate\Support\Facades\File;
class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable) {
        abort_if(Gate::denies('access_user_management'), 403);

        return $dataTable->render('user::users.index');
    }


    public function create() {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::users.create');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active
        ]);

    $user->assignRole($request->role);
        if ($request->has('image')) {
            $tempFile = Upload::where('folder', $request->image)->first();

            if ($tempFile) {
                $user->addMedia(Storage::path('public/temp/' . $request->image . '/' . $tempFile->filename))->toMediaCollection('avatars');

                Storage::deleteDirectory('public/temp/' . $request->image);
                $tempFile->delete();
            }
        }

        toast("User Created & Assigned '$request->role' Role!", 'success');

        return redirect()->route('users.index');
    }


    public function edit(User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::users.edit', compact('user'));
    }


    public function update(Request $request, User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,'.$user->id,
        ]); 

        $user->syncRoles($request->role);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image) {
                $oldImagePath = public_path($user->image);
                if (File::exists($oldImagePath)) {
                    // File::delete($oldImagePath);
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
                'is_active' => $request->is_active,
                'image' => 'images/users/' . $imageName,
            ]);
        } else {
            // No image uploaded
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'is_active' => $request->is_active
            ]);
        }
        toast("User Updated & Assigned '$request->role' Role!", 'info');

        return redirect()->route('users.index');
    }


    public function destroy(User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        $user->delete();

        toast('User Deleted!', 'warning');

        return redirect()->route('users.index');
    }
}
