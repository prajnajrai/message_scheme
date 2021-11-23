<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function edit(User $user)
	{
		$title = 'Edit User Account';
		return view('admin.pages.users.account', compact('title', 'user'));
	}

	public function update(User $user, UserUpdateRequest $request)
	{
		$user->update($request->except('password'));
		if($request->password)
		{
			$user->update(['password' => Hash::make($request->password)]);
		}
		return back()->withStatus('Profile details have been updated successfully.');
	}

	public function home(){
		return view('home');
	}
}