<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denomination;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(){
        $current_user = Auth::user();
        $denominations = Denomination::all();
        return view("admin.settings.index", compact(["denominations","current_user"]));
    }


    public function store(Request $request)
    {
    // verify
    try {
        // dd($request);
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'nullable',
            'denomination' => 'nullable',
            'userID' => 'required'

        ]);

        // Create the new department
        User::find($validatedData['userID'])->update([
            'name'=> $validatedData['name'],
            'denomination_id'=> $validatedData['denomination'],
        ]);


        // Redirect back with a success message
        return redirect()->route('admin.denominations.index')->with('success', 'Denomination created successfully!');
    } catch (\Exception $e) {
        // Log the error message (optional)
        \Log::error($e->getMessage());

        session()->flash("error",'Something went wrong while updating your data. Please try again.' . $e);
        // Redirect back with an error message
        return redirect()->back()->withInput();
    }


    }
}
