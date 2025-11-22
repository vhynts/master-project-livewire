<?php

namespace App\Livewire\Roles;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.main')]
#[Title('Edit Role')]
class Edit extends Component
{
    public Role $role;
    public $name = '';
    public $selectedPermissions = [];

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'selectedPermissions' => 'array',
        ]);

        if ($this->role->name === 'root' && $this->name !== 'root') {
             session()->flash('error', 'Nama role root tidak boleh diubah.');
             return;
        }

        $this->role->update(['name' => $this->name]);
        $this->role->syncPermissions($this->selectedPermissions);

        session()->flash('success', 'Role berhasil diperbarui.');

        return $this->redirect(route('roles.index'), navigate: true);
    }

    public function render()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($data) {
            return explode('.', $data->name)[0];
        });

        return view('livewire.roles.edit', [
            'groupedPermissions' => $permissions,
        ]);
    }
}
