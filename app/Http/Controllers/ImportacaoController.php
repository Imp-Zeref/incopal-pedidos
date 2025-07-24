<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessarImportacaoProdutos;

class ImportacaoController extends Controller
{
    public function showProdutosForm()
    {
        return view('importar.produtos');
    }

    public function importProdutos(Request $request)
    {
        $request->validate([
            'arquivo_csv' => 'required|mimes:csv,txt|file'
        ]);

        // Salva o arquivo no disco local (garantido)
        $caminho = $request->file('arquivo_csv')->store('importacoes_csv', 'local');
        $caminhoCompleto = storage_path('app/' . $caminho);

        // Despacha a job com pequeno delay para evitar corrida
        ProcessarImportacaoProdutos::dispatch($caminhoCompleto)->delay(now()->addSeconds(2));
        
        return redirect()->back()->with('sucesso', 'Importação iniciada! Os produtos serão atualizados em segundo plano.');
    }
}
