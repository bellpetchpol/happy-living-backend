<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('tax_code')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('address')->nullable();
            $table->string('juristic_manager_name_th')->nullable();
            $table->string('juristic_manager_name_en')->nullable();
            $table->string('project_manager_name_th')->nullable();
            $table->string('project_manager_name_en')->nullable();
            $table->string('accounting_manager_name_th')->nullable();
            $table->string('accounting_manager_name_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
