<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileUpdateController extends Controller
{
    public function index($id)
    {
        

        $user = User::with('profile')->find($id);
        return $user->profile->id;
    }

    public function update(Request $request)
    {

    }
}
