<?php

namespace App\controllers;

use App\services\AuthService;

class AuthController extends BaseController
{
	use AuthService;
	
	/**
	 * @throws \Exception
	 */
	public function login(): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Handle login
			try {
				$isLoggedIn = $this->loginUser($_POST);
			} catch (\Exception $e) {
				
				$this->view('auth/login', [ 'error' => 'Invalid email or password.' ]);
				exit;
			}
			
			if ($isLoggedIn) {
				header('Location: /');
				exit;
			}
			$this->view('auth/login', [ 'error' => 'Invalid email or password.' ]);
		}
		
		$this->view('auth/login');
	}
	
	/**
	 * @throws \Exception
	 */
	public function signUp(): void
	{
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Handle sign-up
			$isRegistered = $this->registerUser($_POST);
			
			if ($isRegistered) {
				header('Location: /login');
				exit;
			}
			$this->view('auth/sign-up', [ 'error' => 'something went wrong.' ]);
		}
		
		$this->view('auth/sign-up');
	}
	
	public function logOut(): void
	{
		// Destroy session
		session_unset();
		session_destroy();
		header('Location: /login');
	}
	
}