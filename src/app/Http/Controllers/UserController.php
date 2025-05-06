<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, Response::HTTP_OK);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);

        return response()->json($user, Response::HTTP_OK);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json($user, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}
