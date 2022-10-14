<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\AbilityModule;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Role::firstOrCreate([
			'name' => 'Admin',
			'label' => 'Administrator',
		]);
		Role::firstOrCreate([
			'name' => 'User',
			'label' => 'Normal User',
		]);

		$role = Role::find(1);
		if ($role) {
			$ability_ids = AbilityModule::whereIn('module', [
				'Doctor',
				'Medicine',
				'Patient',
				'Consultation',
				'Labor',
				'Echography',
				'XRay',
				'ECG',
				'ParaClinic',
				'Prescription',
			])
			->with(['abilities'])
			->get()
			->map(function ($ability_module){
				return $ability_module->abilities->pluck('id')->toArray();
			})->toArray();
			$role->allowTo($ability_ids);
		}
		
		$role2 = Role::find(2);
		if ($role2) {
			$ability_ids2 = AbilityModule::whereIn('module', [
				'Patient',
				'Consultation',
				'Labor',
				'Echography',
				'XRay',
				'ECG',
				'ParaClinic',
				'Prescription',
			])
			->with(['abilities'])
			->get()
			->map(function ($ability_module){
				return $ability_module->abilities->pluck('id')->toArray();
			})->toArray();
			$role2->allowTo($ability_ids2);
		}
	}
}
