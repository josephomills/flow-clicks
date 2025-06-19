<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DenominationController extends Controller
{
    public function index()
    {
        $mailing_address = env('MAIL_FROM_ADDRESS');
        // Logic to display user denominations
        $user = auth()->user();
        $denominations = $user->denominations()->get();

        return view('user.denominations.index', [
            'denominations' => $denominations,
            'mailing_address' => $mailing_address,
        ]);
    }
}
