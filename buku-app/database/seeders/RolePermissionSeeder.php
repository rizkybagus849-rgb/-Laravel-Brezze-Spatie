<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan cache permission Spatie
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'book.view', 'book.create', 'book.edit', 'book.delete', 'user.manage-roles',
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // Matriks hak akses
        $matrix = [
            'Admin'     => $permissions,
            'Dosen'     => ['book.view', 'book.create', 'book.edit'],
            'Mahasiswa' => ['book.view'],
        ];
        foreach ($matrix as $roleName => $perms) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web'])
                ->syncPermissions($perms);
        }

        // Akun pengujian
        $accounts = [
            ['Admin Uji',     'admin@example.com',     'Admin'],
            ['Dosen Uji',     'dosen@example.com',     'Dosen'],
            ['Mahasiswa Uji', 'mahasiswa@example.com', 'Mahasiswa'],
        ];
        foreach ($accounts as [$name, $email, $role]) {
            $user = User::firstOrNew(['email' => $email]);
            $user->forceFill([
                'name' => $name,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ])->save();
            $user->syncRoles($role);
        }
    }
}
