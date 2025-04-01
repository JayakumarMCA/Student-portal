<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('s_for'); // Purpose of the campaign
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaign_masters');
    }
};
