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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Camps del Projecte
            $table->string('code', 50)->unique();
            $table->text('description');
            $table->enum('status', ['ToDo', 'Doing', 'Done'])->default('ToDo');
            $table->date('due_date')->nullable();
            
            // Claus Foranes
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('priority_id')->constrained('priorities');
            
            // Creem la columna 'creation_date' manualment per complir amb Task.php
            $table->timestamp('creation_date'); 
            // I el camp 'updated_at' (que no canvia de nom)
            $table->timestamp('updated_at')->nullable(); 

            // Ja NO fem servir: $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
