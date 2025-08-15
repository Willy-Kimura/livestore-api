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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Guest', 'Client'])->default('Guest')->nullable();
            $table->string('secondary_id')->unique()->nullable();
            $table->string('fingerprint_id')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->enum('gender', ['Male', 'Female', 'Not Applicable', 'Not Known'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('document_type', ['National ID', 'Passport', 'Driving License', 'Birth Certificate'])->nullable();
            $table->string('document_id')->unique()->nullable();
            $table->string('default_phone')->nullable();
            $table->string('default_phone_sha256')->nullable();
            $table->text('default_address')->nullable();
            $table->string('country')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->text('avatar')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
