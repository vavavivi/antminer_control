<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateHostsTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			Schema::create('hosts', function (Blueprint $table) {
				$table->increments('id');
				$table->string('mac', 17)->unique();
				$table->string('ip', 15);
				$table->boolean('ip_static');

				$table->string('pool1_url', 255);
				$table->string('pool1_worker', 255);
				$table->string('pool1_password', 255);
				$table->string('pool2_url', 255);
				$table->string('pool2_worker', 255);
				$table->string('pool2_password', 255);
				$table->string('pool3_url', 255);
				$table->string('pool3_worker', 255);
				$table->string('pool3_password', 255);

				$table->string('frequency', 5);
				$table->integer('hw');

				$table->string('elapsed', 10);

				$table->double('ghs_5s', 10, 2);
				$table->double('ghs_avg', 10, 2);

				$table->tinyInteger('temp1');
				$table->tinyInteger('temp2');

				$table->integer('fan1');
				$table->integer('fan2');
				$table->integer('fan3');
				$table->integer('fan4');

				$table->boolean('active');

				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			Schema::drop('hosts');
		}
	}
