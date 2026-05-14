<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run if the column exists
        if (!Schema::hasTable('professors') || !Schema::hasColumn('professors', 'email')) {
            return;
        }

        // SQLite doesn't support dropping columns directly; recreate the table without `email`.
        DB::beginTransaction();
        try {
            DB::statement('CREATE TABLE professors_new (id INTEGER PRIMARY KEY AUTOINCREMENT, nome VARCHAR(255) NOT NULL, created_at DATETIME NULL, updated_at DATETIME NULL)');
            DB::statement('INSERT INTO professors_new (id, nome, created_at, updated_at) SELECT id, nome, created_at, updated_at FROM professors');
            DB::statement('DROP TABLE professors');
            DB::statement('ALTER TABLE professors_new RENAME TO professors');
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If the table doesn't exist, nothing to do
        if (!Schema::hasTable('professors')) {
            return;
        }

        // Add the email column back as nullable (safe reverse)
        if (!Schema::hasColumn('professors', 'email')) {
            Schema::table('professors', function ($table) {
                $table->string('email')->nullable();
            });
        }
    }
};
