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
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('author');
            $table->dropColumn('category');
            $table->dropColumn('tags');
            $table->unsignedBigInteger('category_id')->after('user_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreignId('post_id')->constrained()->onDelete('cascade');
            // $table->foreignId('category_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
