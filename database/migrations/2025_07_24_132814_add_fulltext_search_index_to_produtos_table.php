<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("CREATE EXTENSION IF NOT EXISTS unaccent");
        DB::statement('ALTER TABLE produtos ADD COLUMN search_vector TSVECTOR');

        DB::statement("
            CREATE TRIGGER tsvectorupdate
            BEFORE INSERT OR UPDATE ON produtos
            FOR EACH ROW EXECUTE PROCEDURE
            tsvector_update_trigger(
                search_vector, 'pg_catalog.portuguese',
                codigo, descricao, descricao2, descricao3,
                aplicacao, original, secundario, localizacao, diversa
            );
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS tsvectorupdate ON produtos');
        DB::statement('ALTER TABLE produtos DROP COLUMN IF EXISTS search_vector');
    }
};
