<?php

namespace Pingu\Taxonomy\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Pingu\Menu\Entities\Menu;
use Pingu\Menu\Entities\MenuItem;
use Pingu\Permissions\Entities\Permission;
use Pingu\Taxonomy\Entities\Taxonomy;

class TaxonomyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item =  MenuItem::findByName('admin-menu.structure.taxonomy');
        if(!$item){
            $perm = Permission::findOrCreate(['name' => 'view taxonomy vocabularies', 'section' => 'Taxonomy']);
            Permission::findOrCreate(['name' => 'edit taxonomy vocabularies', 'section' => 'Taxonomy']);
            Permission::findOrCreate(['name' => 'delete taxonomy vocabularies', 'section' => 'Taxonomy']);
            Permission::findOrCreate(['name' => 'add taxonomy vocabularies', 'section' => 'Taxonomy']);
            Permission::findOrCreate(['name' => 'view taxonomy terms', 'section' => 'Taxonomy']);
            Permission::findOrCreate(['name' => 'add taxonomy terms', 'section' => 'Taxonomy']);
            Permission::findOrCreate(['name' => 'edit taxonomy terms', 'section' => 'Taxonomy']);
            Permission::findOrCreate(['name' => 'delete taxonomy terms', 'section' => 'Taxonomy']);

            $menu = Menu::findByName('admin-menu');
            $structure = MenuItem::findByName('admin-menu.structure');
            $tax = MenuItem::create([
                'name' => 'Taxonomy',
                'deletable' => 0,
                'url' => 'taxonomy.admin.taxonomy',
                'permission_id' => $perm->id,
                'active' => 1
            ], $menu, $structure);

            $tag = Taxonomy::create([
                'name' => 'Tags',
                'machineName' => 'tags'
            ]);
        }
    }
}
