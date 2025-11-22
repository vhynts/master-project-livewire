<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Spatie\Permission\Models\Role;

#[Layout('layouts.main')]
#[Title('Daftar Pengguna')]
class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $q = '';

    #[Url(history: true)]
    public $role = '';

    #[Url(history: true)]
    public $status = '';

    #[Url(history: true)]
    public $sortCol = 'created_at';

    #[Url(history: true)]
    public $sortAsc = false;

    public function sortBy($column)
    {
        if ($this->sortCol === $column) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortCol = $column;
            $this->sortAsc = true;
        }
    }

    public function updated($property)
    {
        if (in_array($property, ['q', 'role', 'status'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['q', 'role', 'status', 'sortCol', 'sortAsc']);
        $this->resetPage();
    }

    protected $listeners = ['deleteConfirmed' => 'deleteConfirmed'];

    public function deleteConfirmed($id)
    {
        // Check if user has permission to delete users
        $this->authorize('users.delete');
        
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', 'Pengguna berhasil dihapus.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->q, function ($query, $q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->when($this->role, function ($query, $role) {
                $query->whereHas('roles', function ($query) use ($role) {
                    $query->where('name', $role);
                });
            })
            ->when($this->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->with('roles')
            ->orderBy($this->sortCol, $this->sortAsc ? 'asc' : 'desc')
            ->paginate(10);

        $roles = Role::orderByRaw("CASE WHEN name = 'root' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        return view('livewire.users.index', compact('users', 'roles'));
    }
}
