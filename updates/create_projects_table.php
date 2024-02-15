<?php namespace Pensoft\Projects\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateProjectsTable Migration
 */
class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('pensoft_projects_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->text('content')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pensoft_projects_projects');
    }
}
