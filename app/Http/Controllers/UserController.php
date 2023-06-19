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

    public function getAllUsers()
    {
        try {
            $users = User::all();
            return $this->responseSuccess($users);
        } catch (Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findUserById(Request $request)
    {
        try {
            $users = User::find($request->id);
            if (!$users) {
                return $this->responseError(null, 'User Not Found', 404);
            }
            return $this->responseSuccess($users);
        } catch (Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->last_name);

            $user = User::where('id', $request->id)->update($data);
            if (!$user)
            {
                return $this->responseError(null, 'User Not Found', 404);
            }
            $user = User::find($request->id);
            return $this->responseSuccess($user);
        } catch (Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUserById(Request $request)
    {
        try {
            $user = User::find($request->id);
            if (!$user)
            {
                return $this->responseError(null, 'User Not Found', 404);
            }
            $user->delete($request->id);
            return $this->responseSuccess(null, 'Deleted Successfully',204);
        } catch (Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
