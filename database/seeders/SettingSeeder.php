<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Setting::firstOrCreate([
			'id' => 1,
			'clinic_name_kh' => 'មន្ទីរសម្រាកព្យាបាល និង សម្ភព  មរកត ',
			'clinic_name_en' => 'MOROKOT CLINIC & MATERNITY',
			'sign_name_kh' => 'Name KH',
			'sign_name_en' => 'Name EN',
			'phone' => '016 77 00 98',
			'address' => 'Address',
			'description' => 'ជំងឺទូទៅ ទឹកនោមផ្អែម លើសសម្ពាធឈាម មនុស្សចាស់ កុមារ និងរោគស្រ្ដី វះកាត់តូច ថតអេកូរ សម្ភព <br/>
			ពិនិត្យឈាម ពិនិត្យកំហាប់ឆ្អឹង វ៉ាក់សាំងសាំ ការពារ ថ្លើមបេ មហារីករីមាត់ស្បូន ឆ្កែឆ្កួត',
		]);
	}
}
