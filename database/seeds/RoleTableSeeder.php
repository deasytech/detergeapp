<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role_admin = new Role();
      $role_admin->name = 'admin';
      $role_admin->description = 'Application Admin';
      $role_admin->save();

      $accountant_admin = new Role();
      $accountant_admin->name = 'accountant';
      $accountant_admin->description = 'Application Accountant';
      $accountant_admin->save();

      $manager_admin = new Role();
      $manager_admin->name = 'manager';
      $manager_admin->description = 'Application Manager';
      $manager_admin->save();

      $technician_admin = new Role();
      $technician_admin->name = 'technician';
      $technician_admin->description = 'Application Technician';
      $technician_admin->save();

      $user_admin = new Role();
      $user_admin->name = 'user';
      $user_admin->description = 'Application User';
      $user_admin->save();
    }
}
