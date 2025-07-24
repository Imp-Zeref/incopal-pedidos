<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE produtos ADD COLUMN search_vector TSVECTOR');
        DB::statement("
            CREATE TRIGGER tsvectorupdate BEFORE INSERT OR UPDATE
            ON produtos FOR EACH ROW EXECUTE PROCEDURE
            tsvector_update_trigger(search_vector, 'pg_catalog.portuguese', nome, descricao, original, secundario, localizacao, diversa);
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS tsvectorupdate ON produtos');
        DB::statement('DROP COLUMN IF EXISTS search_vector');
    }
};