<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("user_id");
            $table->boolean("is_active")->default(true);
            $table->boolean("is_default")->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->restrictOnDelete()
                ->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
