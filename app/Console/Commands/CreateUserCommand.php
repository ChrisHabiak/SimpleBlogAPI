<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;

/**
 * Created by AI
 *
 */

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the name input from the user.
        $name = $this->ask('Enter user name:');

        // Get the email input from the user.
        $email = $this->ask('Enter user email:');

        // Check if the email already exists in the system.
        $existingUser = User::where('email', $email)->first();

        // If the user exists, offer to update their role.
        if ($existingUser) {
            $this->line('User with this email already exists.');

            $changeRole = $this->confirm('Do you want to change the user\'s role?', false);
            if ($changeRole) {
                $roles = Role::pluck('name')->toArray();
                $role = $this->choice('Select user role:', $roles);

                $existingUser->role()->associate(Role::where('name', $role)->first());
                $existingUser->save();

                $this->info('User role changed successfully!');
            } else {
                $this->info('User not created.');
            }

            return;
        }

        // If the user doesn't exist, then create a new user.
        $roles = Role::pluck('name')->toArray();
        $role = $this->choice('Select user role:', $roles);

        $user = new User();
        $user->name = $name;
        $user->email = $email;

        // Set a password.
        $password = Str::password();
        $user->password = Hash::make($password);

        // Set the selected role to the user and save the user in the database.
        $user->role()->associate(Role::where('name', $role)->first());
        $user->save();

        $this->info('User created successfully!');
        $this->info('Login: '.$email);
        $this->info('Password: '.$password);
    }

}
