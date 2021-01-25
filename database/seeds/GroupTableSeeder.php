<?php

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Permission;
class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $map=config('trusting.map');
        $models=config('trusting.models');
        $admin=config('trusting.administratorGroup');


        $models['Admin'] = ['c','r','d','u'];

        $separator='_';

        $systemAdmin=Group::create($admin);

        foreach ($models as $modelName => $modelPermissions){
            foreach ($modelPermissions as $permission){
                $permissionObject=Permission::create([
                    'name'  =>strtolower($map[$permission] . $separator .$modelName),
                    'display_name'  =>ucwords(strtolower($map[$permission] . '  ' . $modelName))
                ]);
                $systemAdmin->permissions()->attach($permissionObject->id);
            }
        }
    }
}
