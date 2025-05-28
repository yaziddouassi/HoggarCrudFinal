<?php

namespace  Hoggarcrud\Hoggar\Commands;

use Illuminate\Console\Command;
use App\Models\User; // Ensure you import the User model
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:hoggar-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user and store it in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ask for user input
        $name = $this->ask('What is the user\'s name?');
        $email = $this->ask('What is the user\'s email?');
        $password = $this->secret('What is the user\'s password?');

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email format. Please try again.');
            return Command::FAILURE;
        }

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');
            return Command::FAILURE;
        }

        // Create the user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Display success message
        $this->info('User created successfully!');
        $this->line('User Details:');
        $this->line("Name: {$user->name}");
        $this->line("Email: {$user->email}");

        return Command::SUCCESS;
    }
}
