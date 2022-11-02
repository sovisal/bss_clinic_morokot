<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function (Blueprint $table) {
			$table->id();
			$table->datetime('inv_date')->nullable();
			$table->integer('doctor_id')->nullable();
			$table->string('remark')->nullable();
			$table->integer('pt_id')->nullable();
			$table->integer('pt_gender')->nullable();
			$table->integer('pt_age')->nullable();
			$table->integer('address_id')->nullable();
			$table->float('exchange_rate')->default('0');
			$table->float('total')->default('0');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('invoices');
	}
}
