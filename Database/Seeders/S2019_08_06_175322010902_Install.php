<?php

use Pingu\Core\Seeding\DisableForeignKeysTrait;
use Pingu\Core\Seeding\MigratableSeeder;
use Pingu\Menu\Entities\Menu;
use Pingu\Menu\Entities\MenuItem;
use Pingu\Permissions\Entities\Permission;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\User\Entities\Role;

class S2019_08_06_175322010902_Install extends MigratableSeeder
{
    use DisableForeignKeysTrait;

    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $admin = Role::findByName('Admin');
        $perm = Permission::findOrCreate(['name' => 'view taxonomy vocabularies', 'section' => 'Taxonomy']);

        $admin->givePermissionTo([
            $perm,
            Permission::findOrCreate(['name' => 'edit taxonomy vocabularies', 'section' => 'Taxonomy']),
            Permission::findOrCreate(['name' => 'delete taxonomy vocabularies', 'section' => 'Taxonomy']),
            Permission::findOrCreate(['name' => 'add taxonomy vocabularies', 'section' => 'Taxonomy']),
            Permission::findOrCreate(['name' => 'view taxonomy terms', 'section' => 'Taxonomy']),
            Permission::findOrCreate(['name' => 'add taxonomy terms', 'section' => 'Taxonomy']),
            Permission::findOrCreate(['name' => 'edit taxonomy terms', 'section' => 'Taxonomy']),
            Permission::findOrCreate(['name' => 'delete taxonomy terms', 'section' => 'Taxonomy'])
        ]);

        $menu = Menu::findByMachineName('admin-menu');
        $structure = MenuItem::findByMachineName('admin-menu.structure');
        $tax = MenuItem::create(
            [
            'name' => 'Taxonomy',
            'deletable' => 0,
            'url' => 'taxonomy.admin.index',
            'permission_id' => $perm->id,
            'active' => 1
            ], $menu, $structure
        );

        $tag = Taxonomy::create(
            [
            'name' => 'Tags',
            'machineName' => 'tags'
            ]
        );
    }

    /**
     * Reverts the database seeder.
     */
    public function down(): void
    {
        // Remove your data
    }
}
