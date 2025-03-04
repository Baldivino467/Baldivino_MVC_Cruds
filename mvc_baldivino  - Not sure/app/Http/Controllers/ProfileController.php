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
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $user = $request->user();
        $user->fill($request->only('name', 'email'));
        
        // If email is changed, update it in both tables
        if ($user->isDirty('email')) {
            // Update the student record if the user is a student
            if ($user->role === 'student') {
                $student = \App\Models\Student::where('email', $user->getOriginal('email'))->first();
                if ($student) {
                    $student->update([
                        'email' => $request->email,
                        'name' => $request->name
                    ]);
                }
            }
        } else {
            // If only name is changed, update student record
            if ($user->role === 'student') {
                $student = \App\Models\Student::where('email', $user->email)->first();
                if ($student) {
                    $student->update([
                        'name' => $request->name
                    ]);
                }
            }
        }

        $user->save();

        return redirect()->back()->with('status', 'profile-updated');
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
