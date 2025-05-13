<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    //
    public function UserAll(Request $request)
    {
        $data = [];
        $data['page_title'] = 'API';

        $response = Http::get('https://jsonplaceholder.typicode.com/users');

        if ($response->successful()) {
            $users = $response->json();

            foreach ($users as $userData) {
                User::updateOrCreate(
                    ['email' => $userData['email']], 
                    [
                        'name' => $userData['name'],
                        'address' => $userData['address']['street'] . ', ' . $userData['address']['city'],
                    ]
                );
            }

            if ($request->has('search')) {
                $search = $request->input('search');
                $users = collect($users)->filter(function ($user) use ($search) {
                    return stripos($user['name'], $search) !== false;
                });
            }

            return view('backend.user.all', compact('users'))->with('page_title', $data['page_title']);
        }

        return redirect()->back()->withErrors('Error fetching users from API.');
    }

    
}
