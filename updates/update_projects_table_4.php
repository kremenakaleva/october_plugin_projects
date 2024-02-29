<?php namespace Pensoft\Projects\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * UpdateProjectsTable Migration
 */
class UpdateProjectsTable4 extends Migration
{
    public function up()
    {
        Schema::table('pensoft_projects_projects', function(Blueprint $table)
        {
            $table->renameColumn('keywords', 'keywords_en');
            $table->text('keywords_bg')->nullable();

        });
    }
    
    public function down()
    {
        Schema::table('pensoft_projects_projects', function(Blueprint $table)
        {
            $table->renameColumn('keywords_en', 'keywords');
            $table->dropColumn('keywords_bg');

        });
    }
}
