<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UpdateUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

public function handle()
{
    $response = Http::get('https://jsonplaceholder.typicode.com/users');

    if ($response->successful()) {
        $users = $response->json();

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'address' => $userData['address']['street'] . ', ' . $userData['address']['city'],
                    'password' => bcrypt('default123'), 
                ]
            );
        }

        $this->info('User data updated successfully.');
    } else {
        $this->error('Failed to fetch user data from API.');
    }
}

}
