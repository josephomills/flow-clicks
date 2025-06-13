<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Denomination;
use Livewire\Component;

class UserEditForm extends Component
{
    public User $user;
    public $first_name;
    public $last_name;
    public $email;
    public $denomination;
    public $allowMultiLinks = false;
    public $assigned_denominations = [];
    public $denomination_search = '';
    public $search_results = [];
    public $show_dropdown = false;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'denomination' => 'required|exists:denominations,id',
        'assigned_denominations' => 'array',
        'assigned_denominations.*' => 'exists:denominations,id',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->denomination = $user->denomination_id;
        $this->allowMultiLinks = $user->role === 'admin';
        $this->assigned_denominations = $user->denominations->pluck('id')->toArray();
    }

    public function updatedDenominationSearch()
    {
        if (strlen($this->denomination_search) >= 1) {
            $this->searchDenominations();
            $this->show_dropdown = true;
        } else {
            $this->search_results = [];
            $this->show_dropdown = false;
        }
    }

    public function searchDenominations()
    {
        $this->search_results = Denomination::where('name', 'like', '%' . $this->denomination_search . '%')
            ->orderBy('name')
            ->limit(20)
            ->get()
            ->map(function ($denomination) {
                return [
                    'id' => $denomination->id,
                    'name' => $denomination->name,
                    'selected' => in_array($denomination->id, $this->assigned_denominations)
                ];
            })
            ->toArray();
    }

    public function toggleDenomination($denominationId)
    {
        $denominationId = (int) $denominationId;

        if (in_array($denominationId, $this->assigned_denominations)) {
            // Remove denomination
            $this->assigned_denominations = array_filter($this->assigned_denominations, function ($id) use ($denominationId) {
                return (int) $id !== $denominationId;
            });
            $this->assigned_denominations = array_values($this->assigned_denominations);
        } else {
            // Add denomination
            $this->assigned_denominations[] = $denominationId;
        }

        // Refresh search results to update selection state
        if (strlen($this->denomination_search) >= 1) {
            $this->searchDenominations();
        }
    }

    public function removeDenomination($denominationId)
    {
        $denominationId = (int) $denominationId;

        $this->assigned_denominations = array_filter($this->assigned_denominations, function ($id) use ($denominationId) {
            return (int) $id !== $denominationId;
        });

        $this->assigned_denominations = array_values($this->assigned_denominations);

        // Refresh search results if dropdown is open
        if ($this->show_dropdown && strlen($this->denomination_search) >= 1) {
            $this->searchDenominations();
        }
    }

    public function showDropdown()
    {
        $this->show_dropdown = true;
        if (empty($this->denomination_search)) {
            // Show all denominations when opening without search
            $this->search_results = Denomination::orderBy('name')
                ->limit(20)
                ->get()
                ->map(function ($denomination) {
                    return [
                        'id' => $denomination->id,
                        'name' => $denomination->name,
                        'selected' => in_array($denomination->id, $this->assigned_denominations)
                    ];
                })
                ->toArray();
        }
    }

    public function hideDropdown()
    {
        $this->show_dropdown = false;
    }

    public function clearSearch()
    {
        $this->denomination_search = '';
        $this->search_results = [];
        $this->show_dropdown = false;
    }

    public function save()
    {
        // Create dynamic validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'denomination' => 'required|exists:denominations,id',
            'assigned_denominations' => 'array',
            'assigned_denominations.*' => 'exists:denominations,id',
        ];

        $this->validate($rules);

        try {
            $role = $this->allowMultiLinks ? 'admin' : 'user';

            $this->user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'denomination_id' => $this->denomination,
                'role' => $role,
            ]);

            // Sync assigned denominations
            $this->user->denominations()->sync($this->assigned_denominations);

            session()->flash('success', 'User updated successfully!');

            return redirect()->route('admin.users.index');

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while updating the user.');
        }
    }

    public function cancel()
    {
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        $denominations = Denomination::all();
        $assigned_denomination_names = [];

        if (!empty($this->assigned_denominations)) {
            $assigned_denomination_names = Denomination::whereIn('id', $this->assigned_denominations)
                ->pluck('name', 'id')
                ->toArray();
        }

        return view('livewire.admin.user-edit-form', [
            'denominations' => $denominations,
            'assigned_denomination_names' => $assigned_denomination_names,
        ])->extends('layouts.admin')->section('content');
    }
}