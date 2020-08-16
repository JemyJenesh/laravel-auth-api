<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $users = [
      ['name' => 'Admin', 'email' => 'admin@admin.com', 'role_id' => 1],
      ['name' => 'User', 'email' => 'user@user.com', 'role_id' => 2],
      ['name' => 'Normal User', 'email' => 'normaluser@user.com', 'role_id' => 2],
      ['name' => 'Another User', 'email' => 'anotheruser@user.com', 'role_id' => 2],
    ];

    foreach ($users as $user) {
      $now = Carbon::now();
      DB::table('users')->insert([
        'name' => $user['name'],
        'email' => $user['email'],
        'password' => Hash::make('password'),
        'role_id' => $user['role_id'],
        'created_at' => $now,
        'updated_at' => $now,
      ]);
    }
  }
}
