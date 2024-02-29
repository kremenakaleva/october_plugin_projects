<?php namespace Pensoft\Projects\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * UpdateProjectsTable Migration
 */
class UpdateProjectsTable3 extends Migration
{
    public function up()
    {
        Schema::table('pensoft_projects_projects', function(Blueprint $table)
        {
            $table->boolean('published')->nullable();
            $table->text('tag')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('pensoft_projects_projects', function(Blueprint $table)
        {
            $table->dropColumn('published');
            $table->dropColumn('tag');
        });
    }
}
