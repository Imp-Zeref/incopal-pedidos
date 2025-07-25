<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessarImportacaoProdutos;
use Illuminate\Support\Facades\DB;

class ImportacaoController extends Controller
{
    public function showProdutosForm()
    {

        $falhas = DB::table('failed_jobs')
            ->latest('failed_at')
            ->limit(10)
            ->get();
        
        $jobsPendentes = DB::table('jobs')->count();

        return view('importar.produtos', compact('falhas', 'jobsPendentes'));
    }

    public function importProdutos(Request $request)
    {
        $request->validate([
            'arquivo_csv' => 'required|mimes:csv,txt|file'
        ]);

        $path = $request->file('arquivo_csv')->store('importacoes_csv');
        ProcessarImportacaoProdutos::dispatch($path);

        return redirect()->back()->with('sucesso', 'Importação iniciada! Os produtos serão atualizados em segundo plano.');
    }
}
