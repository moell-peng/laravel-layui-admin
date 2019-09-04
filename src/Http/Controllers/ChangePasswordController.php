<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Auth;
use Hash;
use Moell\LayuiAdmin\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (! Hash::check($request->old_password, $user->password)) {
            return $this->unprocesableEtity([
                'password' => 'Incorrect password'
            ]);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return $this->success();
    }
}