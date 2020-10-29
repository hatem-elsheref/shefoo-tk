<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Group;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminGroup=Group::where('name',config('trusting.administratorGroup')['name'])->value('id');
        $admin=Admin::create([
            'name'      =>'Hatem Mohamed',
            'email'     =>'hatem@app.com',
            'password'  =>bcrypt('12345678'),
            'avatar'    =>'uploads/admins/default-user.png',
            'group'     =>$adminGroup
        ]);
    }
}
