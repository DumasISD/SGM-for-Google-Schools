<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('photos', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->unsignedInteger('language_id');
			$table->foreign('language_id')->references('id')->on('languages');
			$table->integer('position')->nullable();
			$table->boolean('slider')->nullable();
			$table->string('filename', 255);
			$table->string('name', 255)->nullable();
			$table->text('description')->nullable();
			$table->unsignedInteger('photo_album_id')->nullable();
			$table->foreign('photo_album_id')->references('id')->on('photo_albums')->onDelete('set null');
			$table->boolean('album_cover')->nullable();
			$table->unsignedInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->unsignedInteger('user_id_edited')->nullable();
			$table->foreign('user_id_edited')->references('id')->on('users')->onDelete('set null');
			$table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('photos');
	}

}
