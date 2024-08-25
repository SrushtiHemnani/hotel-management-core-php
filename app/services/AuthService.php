<?php

namespace App\services;

use App\models\User;

trait AuthService
{
	/**
	 * @throws \Exception
	 */
	public function loginUser(array $data)
	{
		// Get user by email
		$user = User::where('email', $data['email'])->first();
		
		if (!$user) {
			throw new \Exception('User not found.');
		}
		
		if (!password_verify($data['password'], $user->password)) {
			throw new \Exception('Invalid email or password.');
		}
	
		// Store user in session
		$_SESSION['user_id'] = $user->id;
		$_SESSION['name'] = $user->name;
		$_SESSION['user_data'] = $user;
		return true;
	}
	
	
	/**
	 * @throws \Exception
	 */
	public function registerUser(array $data)
	{
		// Validate data (e.g., check if email is already taken)
		$existingUser = User::where('email', $data['email'])->first();
		if ($existingUser) {
			throw new \Exception('Email is already registered.');
		}
		
		$user = User::create([
			                     'name'     => $data['name'],
			                     'email'    => $data['email'],
			                     'password' => password_hash($data['password'], PASSWORD_DEFAULT),
		                     ]);
		if ($user) {
			// return true if created
			return true;
		}
		return false;
	}
	
}