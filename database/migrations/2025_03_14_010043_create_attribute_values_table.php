<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('entity_id');
            $table->string('value');
            $table->string('entity_type');
            $table->index(['entity_id', 'entity_type']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
}