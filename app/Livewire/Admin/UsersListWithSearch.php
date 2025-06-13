<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UsersListWithSearch extends Component
{
    public function render()

    {
        $users = User::query()
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString(); // Preserve filters in pagination links
        return view('livewire.admin.users-list-with-search', compact('users'));
    }
}
