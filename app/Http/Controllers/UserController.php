<?php

namespace App\Http\Controllers;

use App\Models\Denomination;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $denominations = Denomination::all();
        return view('admin.users.create', compact(['denominations']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'denomination' => 'required|exists:denominations,id'
        ]);

        try {
            // Create the user
            User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'], // Combine first and last name
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'denomination_id' => $validated['denomination']
            ]);

            return redirect()->route('admin.users')->with('success', 'User created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $denominations = Denomination::all();
        return view('admin.users.edit', compact(['user', 'denominations']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, string $id = null)
    {
        // Get user ID from request if not passed as parameter
        $userId = $id ?? $request->input('userID');

        // Find the user
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Validate the request
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $userId,
            'denomination' => 'exists:denominations,id',
            'allowMultiLinks' => 'sometimes|boolean' // Added validation for the switch
        ]);

        try {
            // Build the full name (handle nulls safely)
            $firstName = $validated['first_name'] ?? '';
            $lastName = $validated['last_name'] ?? '';
            $fullName = trim("$firstName $lastName");

            // Prepare update data
            $updateData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'name' => $fullName,
                'email' => $validated['email'],
                'denomination_id' => $validated['denomination'],
                'allow_multi_denomination_links' => $validated['allowMultiLinks'] ?? false // Add the new field
            ];

            // Update the user
            $user->update($updateData);

            return redirect()->back()->with('success', 'User updated successfully.');

        } catch (\Exception $e) {
            \Log::error('User update failed: ' . $e->getMessage(), [
                'user_id' => $userId,
                'exception' => $e
            ]);
            return redirect()->back()->with('error', 'Failed to update user. Please try again.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        // Find the user
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            // Prevent deletion of the currently authenticated user
            if (auth()->check() && auth()->id() == $user->id) {
                return redirect()->back()->with('error', 'You cannot delete your own account.');
            }

            // Delete the user
            $user->delete();

            return redirect()->route('admin.users')->with('success', 'User deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
