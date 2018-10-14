<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'avatar' => 'nullable|image',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'website' => 'nullable|url',
            'bio' => 'nullable'
        ]);

        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection('users/avatar');
            $user->addMediaFromRequest('avatar')->toMediaCollection('users/avatar');
        }

        return tap($user)->update($request->only('name', 'email', 'website', 'bio'));
    }
}
