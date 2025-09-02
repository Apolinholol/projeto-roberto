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
        Schema::table('ads', function (Blueprint $table) {
            // Adicionar campo para múltiplas imagens
            $table->json('image_paths')->nullable()->after('image_path');
            
            // Remover o campo antigo de imagem única (opcional - pode manter para compatibilidade)
            // $table->dropColumn('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('image_paths');
            // Se removeu o image_path, adicionar de volta:
            // $table->string('image_path')->nullable()->after('category_id');
        });
    }
};
