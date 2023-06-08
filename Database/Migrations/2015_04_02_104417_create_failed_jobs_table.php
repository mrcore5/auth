<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedJobsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('failed_jobs');
    }
}

// -- mrcore5.failed_jobs definition
// drop table failed_jobs;
// CREATE TABLE `failed_jobs` (
//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//   `connection` text COLLATE utf8_unicode_ci NOT NULL,
//   `queue` text COLLATE utf8_unicode_ci NOT NULL,
//   `payload` text COLLATE utf8_unicode_ci NOT NULL,
//   `exception` text COLLATE utf8_unicode_ci NOT NULL,
//   `failed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
//   PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
