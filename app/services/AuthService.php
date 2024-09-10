<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Person;
use Exception;

trait AuthService
{
    /**
     * Login user with provided credentials.
     *
     * @param array $data
     * @return bool
     * @throws ValidationException
     * @throws Exception
     */
    public function loginUser(array $data): bool
    {
        // Find the person by email using the generic method
        $person = Person::findByField('email', $data['email']);
        if (!$person) {
            throw new ValidationException('User not found.');
        }

        // Verify the password
        if (!password_verify($data['password'], $person->password)) {
            throw new ValidationException('Invalid email or password.');
        }

        // Store user in session
        $_SESSION['person_id'] = $person->id;
        $_SESSION['name'] = $person->name;
        $_SESSION['person_data'] = $person;

        return true;
    }

    /**
     * Register a new user with provided data.
     *
     * @param array $data
     * @return bool
     * @throws ValidationException
     * @throws Exception
     */
    public function registerUser(array $data): bool
    {
        // Check if the email is already taken using the generic method
        $person = Person::findByField('email', $data['email']);
        if ($person) {
            throw new ValidationException('Email already taken.');
        }

        // Prepare data for insertion
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Create a new Person instance and save it
        $newPerson = new Person();
        $newPerson->name = $data['name'];
        $newPerson->email = $data['email'];
        $newPerson->password = $data['password'];
        $newPerson->phone = $data['phone'] ?? null;
        $newPerson->date_of_birth = $data['date_of_birth'] ?? null;
        $newPerson->address = $data['address'] ?? null;

        try {
            $newPerson->save();  // Use the save method from Person model
        } catch (Exception $e) {
            throw new Exception('Error creating user.');
        }

        return true;
    }
}
