<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\Password\UpdateRequest;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(UpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('profile.edit')->with('message', 'profile updated');
    }
}
