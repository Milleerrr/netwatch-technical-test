<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Define the number of users you want to fetch
        $numberOfUsers = 30;

        // API endpoint to fetch users
        $apiUrl = "https://jsonfakery.com/users/random/{$numberOfUsers}";

        // Fetch data from the API
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $usersData = $response->json();

            foreach ($usersData as $userData) {
                try {
                    // Combine first name and last name for the 'name' field
                    $name = $userData['first_name'] . ' ' . $userData['last_name'];

                    // Check if the user already exists to prevent duplicates
                    if (User::where('email', $userData['email'])->exists()) {
                        continue; // Skip this user
                    }

                    // Create a new user record
                    User::create([
                        'name'          => $name,
                        'email'         => $userData['email'],
                        'profile_pic'   => $userData['profile_pic'],
                        'password'      => Hash::make('password'), // Set a default password
                    ]);
                } catch (\Exception $e) {
                    // Log the error message
                    $this->command->error('Error creating user: ' . $e->getMessage());
                }
            }
        } else {
            // Handle the error if the API call was not successful
            $this->command->error('Failed to fetch users from the API.');
        }
    }
}
