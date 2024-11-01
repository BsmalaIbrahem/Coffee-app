<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\AddressService;
use App\Http\Requests\Address\AddRequest;
use App\Services\PhoneService;
use App\Http\Requests\Phone\AddRequest as AddPhoneRequest;

class ProfileController extends Controller
{
    private $addressService; private $phoneService;

    public function __construct(AddressService $addressService, PhoneService $phoneService)
    {
        $this->addressService = $addressService;
        $this->phoneService = $phoneService;
    }
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

        return Redirect::route('profile.edit')->with('message', 'profile-updated');
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

    public function addAddress(AddRequest $request)
    {
        $this->addressService->addAddress($request->all());
        return redirect()->route('checkout');
    }

    public function addPhoneNumber(AddPhoneRequest $request)
    {
        $this->phoneService->add($request->all());
        return redirect()->route('checkout');
    }
}
