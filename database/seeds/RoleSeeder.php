<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $roles = ['admin', 'user'];
    foreach ($roles as $role) {
      $now = Carbon::now();
      DB::table('roles')->insert(['name' => $role, 'created_at' => $now, 'updated_at' => $now]);
    }
  }
}
