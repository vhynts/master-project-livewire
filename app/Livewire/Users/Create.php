<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Role;

#[Layout('layouts.main')]
#[Title('Tambah Pengguna')]
class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'user';
    public $status = 'active';

    public function save()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'status' => $this->status,
        ]);

        $user->assignRole($this->role);

        session()->flash('success', 'Pengguna berhasil ditambahkan.');

        return redirect()->route('users.index');
    }

    public function render()
    {
        $roles = Role::orderByRaw("CASE WHEN name = 'root' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        return view('livewire.users.create', [
            'roles' => $roles,
        ]);
    }
}
