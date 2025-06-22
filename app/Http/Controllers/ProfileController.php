<?php

namespace App\Http\Controllers;

use App\Enums\Bucket;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\RequesterType;
use App\LocaleStorage\Fileupload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Department;
use App\Models\Team;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // dd(Team::query()->get(),$request->user()->teams);
        return view('profile.edit', [
            'user'           => $request->user(),
            'requester_type' => RequesterType::where('status', 'Active')->get(),
            'teams'           => Team::query()->get(),
            'departments'       => Department::query()->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        $isCreate = $request->user();
        Fileupload::update($request, Bucket::PROFILE, $isCreate, $isCreate->getKey(), User::class, 300, 300);
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
