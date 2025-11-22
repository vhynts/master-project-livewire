# Master Project

A modern Laravel application with comprehensive user and role management system, built with Livewire 3 and Tailwind CSS.

## Features

### 🔐 Authentication & Authorization
- **Login System**: Secure authentication with session management
- **Role-Based Access Control**: Powered by Spatie Laravel Permission
- **Permission Management**: Granular permission system with dynamic middleware
- **Custom 403 Error Page**: User-friendly unauthorized access handling

### 👥 User Management
- **CRUD Operations**: Complete user management (Create, Read, Update, Delete)
- **Advanced Filtering**: Search by name/email, filter by role and status
- **Sortable Columns**: Click to sort by name, email, or status
- **Dynamic Role Assignment**: Roles fetched dynamically from database
- **Status Management**: Active/Inactive user status control
- **SweetAlert2 Integration**: Elegant confirmation dialogs for delete actions

### 🛡️ Role & Permission Management
- **Role CRUD**: Full role management with permission assignment
- **Grouped Permissions**: Permissions organized by module (users, roles, etc.)
- **Bulk Selection**: "Check All" and "Check All per Group" functionality
- **Permission Seeding**: Pre-configured permissions for common actions
- **Protected Roles**: Root role cannot be deleted or renamed
- **Dynamic Permissions**: Simplified display names (e.g., "create" instead of "users.create")

### 🎨 UI/UX Features
- **Modern Design**: Clean, professional interface with Tailwind CSS
- **Responsive Layout**: Mobile-friendly design
- **Real-time Search**: Debounced search with instant results
- **Loading States**: Visual feedback during operations
- **Flash Messages**: Success/error notifications
- **Pagination**: Custom pagination with item counts
- **Avatar Initials**: User/role avatars with first letter
- **Consistent Styling**: Unified design across all pages

## Tech Stack

- **Framework**: Laravel 12.0
- **Frontend**: Livewire 3.7 + Alpine.js
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Permissions**: Spatie Laravel Permission 6.23
- **Notifications**: SweetAlert2
- **Build Tool**: Vite

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd master-project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Update `.env` with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=master_project
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed permissions**
   ```bash
   php artisan db:seed --class=PermissionSeeder
   ```

8. **Build assets**
   ```bash
   npm run dev
   ```

9. **Start the server**
   ```bash
   php artisan serve
   ```

Visit `http://127.0.0.1:8000` in your browser.

## Default Permissions

The system comes with pre-configured permissions:

### Users Module
- `users.index` - View users list
- `users.create` - Create new users
- `users.edit` - Edit existing users
- `users.delete` - Delete users

### Roles Module
- `roles.index` - View roles list
- `roles.create` - Create new roles
- `roles.edit` - Edit existing roles
- `roles.delete` - Delete roles

## Project Structure

```
master-project/
├── app/
│   ├── Livewire/
│   │   ├── Auth/
│   │   │   └── Login.php
│   │   ├── Users/
│   │   │   ├── Index.php
│   │   │   ├── Create.php
│   │   │   └── Edit.php
│   │   ├── Roles/
│   │   │   ├── Index.php
│   │   │   ├── Create.php
│   │   │   └── Edit.php
│   │   ├── Dashboard.php
│   │   └── Profile.php
│   └── Models/
│       └── User.php
├── resources/
│   ├── views/
│   │   ├── livewire/
│   │   │   ├── auth/
│   │   │   ├── users/
│   │   │   ├── roles/
│   │   │   ├── dashboard.blade.php
│   │   │   └── profile.blade.php
│   │   ├── layouts/
│   │   │   └── main.blade.php
│   │   └── errors/
│   │       └── 403.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── database/
│   ├── migrations/
│   └── seeders/
│       └── PermissionSeeder.php
└── routes/
    └── web.php
```

## Key Features Implementation

### Authorization Middleware
Routes are protected using Laravel's `can` middleware:

```php
Route::middleware(['can:users.index'])->group(function () {
    Route::get('/users', UsersIndex::class)->name('users.index');
    // ...
});
```

Component methods are protected using `authorize()`:

```php
public function deleteConfirmed($id)
{
    $this->authorize('users.delete');
    // Delete logic...
}
```

### Dynamic Role Selection
Roles are fetched dynamically from the database:

```php
$roles = Role::orderByRaw("CASE WHEN name = 'root' THEN 0 ELSE 1 END")
    ->orderBy('name')
    ->get();
```

### SweetAlert2 Integration
Client-side confirmation dialogs:

```javascript
@click="$dispatch('swal:confirm', {
    title: 'Apakah Anda yakin?',
    text: 'Data yang dihapus tidak dapat dikembalikan!',
    icon: 'warning',
    method: 'deleteConfirmed',
    id: {{ $id }}
})"
```

### Permission Grouping
Permissions are grouped by module for better organization:

```php
$permissions = Permission::orderBy('name')->get()->groupBy(function ($data) {
    return explode('.', $data->name)[0];
});
```

## Development

### Running in Development
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Watch for asset changes
npm run dev
```

### Building for Production
```bash
npm run build
```

### Clearing Cache
```bash
php artisan optimize:clear
```

## Security Features

- ✅ CSRF Protection on all forms
- ✅ Password hashing with bcrypt
- ✅ Role-based access control
- ✅ Permission-based authorization
- ✅ Protected critical roles (root)
- ✅ Secure session management
- ✅ XSS protection via Blade templating

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

- Built with [Laravel](https://laravel.com)
- UI components with [Livewire](https://livewire.laravel.com)
- Styled with [Tailwind CSS](https://tailwindcss.com)
- Permissions by [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- Alerts by [SweetAlert2](https://sweetalert2.github.io)

## Support

For issues and questions, please open an issue in the repository.
