<?php

namespace App\Http\Controllers\Das;

use App\Actions\Fortify\UpdateUserPassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return  $request->user()->only(['name', 'email', 'role','avatar']);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->user()->id)],
        ]);

        $request->user()->update($validated);

        return response()->json(['success' => true]);
    }

    public function uploadImage(Request $request): JsonResponse
    {
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $previousPath = $request->user()->getRawOriginal('avatar');

            $path =  $file->store('uploads', [
                    'disk' => 'public'
                ]);

            $request->user()->update(['avatar' => $path]);

            if ($previousPath) {
                // Extract the path from the URL
                $previousPath = parse_url($previousPath, PHP_URL_PATH);
                // Remove the leading slash
                $previousPath = ltrim($previousPath, '/');
                Storage::disk('public')->delete($previousPath);
            }
        }

        return response()->json(['message' => 'Profile picture uploaded successfully!']);
    }


    public function changePassword(Request $request, UpdateUserPassword $updater): JsonResponse
    {
        $updater->update(
            auth()->user(),
            [
                'current_password' => $request->currentPassword,
                'password' => $request->password,
                'password_confirmation' => $request->passwordConfirmation,
            ]
        );

        return response()->json(['message' => 'Password changed successfully!']);
    }
}
