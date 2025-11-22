<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

#[Layout('layouts.main')]
#[Title('Edit Pengguna')]
class Edit extends Component
{
    public User $user;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = '';
    public $status = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()->name ?? 'user';
        $this->status = $user->status;
    }

    public function save()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
        ]);

        if ($this->password) {
            $this->user->update(['password' => bcrypt($this->password)]);
        }

        $this->user->syncRoles($this->role);

        session()->flash('success', 'Pengguna berhasil diperbarui.');

        return redirect()->route('users.index');
    }

    public function render()
    {
        $roles = Role::orderByRaw("CASE WHEN name = 'root' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        return view('livewire.users.edit', [
            'roles' => $roles,
        ]);
    }
}
