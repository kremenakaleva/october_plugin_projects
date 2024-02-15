<?php namespace Pensoft\Projects\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * UpdateProjectsTable Migration
 */
class UpdateProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('pensoft_projects_projects', function(Blueprint $table)
        {
            $table->integer('sort_order')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pensoft_projects_projects', function(Blueprint $table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
