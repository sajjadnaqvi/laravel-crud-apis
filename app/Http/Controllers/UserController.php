<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResponseTrait;
use http\Client\Response;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseTrait;

    public function createUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'email|required|unique:users',
                'password' => 'required',
                'first_name' => 'required|max:55',
                'last_name' => 'required|max:55',
                'phone' => 'required'
            ]);
            $validatedData['password'] = Hash::make($request->password);
            $user = User::create($validatedData);
            return $this->responseSuccess($user);
        } catch (Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
