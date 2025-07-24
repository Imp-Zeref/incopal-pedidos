<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;

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

        $caminho = $request->file('arquivo_csv')->getRealPath();
        $csv = Reader::createFromPath($caminho, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');

        $registros = $csv->getRecords();

        foreach ($registros as $registro) {
            $codigo = (string) ($registro['codigo'] ?? '');

            if (empty(trim($codigo))) {
                continue;
            }

            Produto::updateOrCreate(
                ['codigo' => $codigo],
                [
                    'descricao' => $registro['descricao'] ?? null,
                    'original' => $registro['original'] ?? null,
                    'secundario' => $registro['secundario'] ?? null,
                    'localizacao' => $registro['localizacao'] ?? null,
                    'diversa' => $registro['diversa'] ?? null,
                    'unidadeMedida' => $registro['unidademedida'] ?? null,
                ]
            );
        }

        return redirect()->back()->with('sucesso', 'Produtos importados e atualizados com sucesso!');
    }
}
