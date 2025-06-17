<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InviteCreated;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InviteController extends Controller
{
    public function invite(): View
    {
        return view('admin.users.invite');
    }

    /**
     * Process the invitation form submission.
     *
     * @param Request $request The HTTP request containing form data
     * @return RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception If invite cannot be created
     */
    public function process(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|email|max:255'
        ]);

        // Check if invite already exists
        if (Invite::where('email', $validated['email'])->exists()) {
            return redirect()->back()->with('error', 'An invitation has already been sent to this email address.');
        }

        $token = $this->generateUniqueInviteToken();

        $invite = Invite::create([
            'email' => $validated['email'],
            'token' => $token
        ]);

        try {
            Mail::to($validated['email'])->send(new InviteCreated($invite));
        } catch (\Exception $e) {
            $invite->delete(); // Rollback if email fails

            \Log::error('Failed to send invitation email', [
                'email' => $validated['email'],
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', $e->getMessage() . 'Sending invitation failed. Please try again later.');
        }

        return redirect()->back()->with('success', 'Invitation sent successfully.');
    }



    /**
     * Generate a unique invite token.
     *
     * @return string
     */
    protected function generateUniqueInviteToken(): string
    {
        return Str::random(16); // Increased length for better security
    }

    public function accept($token): View
    {
        // Look up the invite
        if (!$invite = Invite::where('token', $token)->first()) {
            abort(404, 'Invalid or expired invitation link');
        }

        return view('auth.invite-register', compact('invite'));
    }

    public function completeRegistration(Request $request, $token): RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify the invite still exists
        if (!$invite = Invite::where('token', $token)->first()) {
            return redirect()->route('login')->with('error', 'Invalid or expired invitation');
        }

        // Create the user
        $user = User::create([
            'email' => $invite->email,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $validated['first_name'],
            'password' => Hash::make($validated['password']),
        ]);

        // Delete the used invite
        $invite->delete();

        // Optionally log the user in automatically
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }
}
