<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->morphs('relatable');
            $table->nullableMorphs('relatable_logo');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_starred')->default(false);
            $table->timestamps();
        });
    }
}
