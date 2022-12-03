<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // bikin role admin jika ada
        $role = Role::findOrCreate('admin');
        //bikin role form category jika ada
        $permissionCategory = Permission::findOrCreate('form category', 'web');
        // bikin permission form product jika ada
        $permissionProduct = Permission::findOrCreate('form product', 'web');
        // role admin admin diberikan hak akses form category dan form products
        $role->givePermissionTo($permissionCategory, $permissionProduct);
    }
}
