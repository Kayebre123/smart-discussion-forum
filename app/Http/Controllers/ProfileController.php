<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's assigned academic tracking group based on role permissions.
     */
    public function updateGroup(Request $request): RedirectResponse
    {
        // 1. Validate that the submitted group exists inside our system records
        $request->validate([
            'group_id' => 'required|exists:groups,id',
        ]);

        $user = Auth::user();

        // 2. Enforce structural grouping constraints based on user role
        if ($user->role === 'student') {
            // Students can only occupy ONE group permanently at a time
            $user->group_id = $request->group_id;
            $user->save();
        } else {
            // Lecturers manage multiple cohorts simultaneously via the many-to-many table
            $user->groups()->syncWithoutDetaching([$request->group_id]);
        }

        // 3. Bounce the user right back to the dashboard with a success signal
        return redirect()->back()->with('success', 'Your academic profile group mapping has been successfully updated.');
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