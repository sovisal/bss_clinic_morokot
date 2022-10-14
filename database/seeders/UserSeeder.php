<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::firstOrCreate([
			'name' => 'Web Developer',
			'username' => 'webdev',
			'image' => 'default.png',
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'position' => 'Web Developer',
			'isWebDev' => true,
		]);
		User::firstOrCreate([
			'name' => 'Morokot',
			'username' => 'morokot',
			'image' => 'default.png',
			'password' => '$2y$10$YsiK1JXueoaXVoac1iSYT./ZNQW/K7WRYZL/JRLJ0EUG/Z.bL0xS2', // 12345678
			'position' => 'Staff',
		]);
		$user = User::find(2);
		if($user){
			$user->assignRole('Admin');
		}
	}
}
