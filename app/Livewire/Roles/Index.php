<?php

namespace App\Livewire\Roles;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('layouts.main')]
#[Title('Manajemen Role')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['deleteConfirmed' => 'deleteConfirmed'];

    public function deleteConfirmed($id)
    {
        // Check if user has permission to delete roles
        $this->authorize('roles.delete');
        
        $role = Role::findOrFail($id);
        
        // Prevent deleting critical roles if needed, e.g., root
        if ($role->name === 'root') {
            session()->flash('error', 'Role root tidak dapat dihapus.');
            return;
        }

        $role->delete();
        
        session()->flash('success', 'Role berhasil dihapus.');
    }

    public function render()
{
    $query = Role::query()
        ->withCount('permissions')
        ->when($this->search, function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%');
        });

    $roles = $query
        // root dulu, baru yang lain
        ->orderByRaw("CASE WHEN name = 'root' THEN 0 ELSE 1 END")
        // lalu urutkan sisanya alfabetis (opsional)
        ->orderBy('name')
        ->paginate(10);

    return view('livewire.roles.index', [
        'roles' => $roles,
    ]);
}
}
