<?php

namespace App\Livewire\Roles;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.main')]
#[Title('Tambah Role')]
class Create extends Component
{
    public $name = '';
    public $selectedPermissions = [];

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'selectedPermissions' => 'array',
        ]);

        $role = Role::create(['name' => $this->name]);
        
        // Convert string IDs to integers if necessary, though Spatie handles it well
        $role->syncPermissions($this->selectedPermissions);

        session()->flash('success', 'Role berhasil dibuat.');

        return $this->redirect(route('roles.index'), navigate: true);
    }

    public function render()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($data) {
            return explode('.', $data->name)[0];
        });

        return view('livewire.roles.create', [
            'groupedPermissions' => $permissions,
        ]);
    }
}
