<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/*
 * Tables:
 *
 * `users`: has 15 columns and 10 records
 * `profiles`: has 30 columns and 10 records
 * `groups`: has 5 columns and 5 records
 * `assets`: has 5 columns and 100 records
 *
 * Relations: 
 *
 * users.id = profiles.user_id
 * groups.id = users.group_id
 * users.id = assets.user_id
 *
 */

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['profile', 'group'])
            ->whereHas('group', function ($query) {
                return $query->where('key', 'students');
            })
            ->get();

        foreach ($users as $user) {
            dump("ID: {$user->id}");
            dump("Email: {$user->email}");
            dump("Phone: {$user->phone}");
            dump("Address: {$user->profile->address}");
            dump("Group: {$user->group->name}");

            if ($user->assets->isNotEmpty()) {
                dump("Assets:");

                $user->assets->each(function ($asset) {
                    dump("- {$asset->name}");
                });
            } else {
                dump("Assets: none");
            }
        }
    }
}
