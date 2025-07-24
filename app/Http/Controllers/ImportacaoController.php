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

        try {
            $caminho = $request->file('arquivo_csv')->getRealPath();
            $csv = Reader::createFromPath($caminho, 'r');
            $csv->setHeaderOffset(0);
            $registros = $csv->getRecords();


            foreach ($registros as $registro) {
                $codigo = (string) ($registro['codigo'] ?? '');

                if (empty(trim($codigo))) {
                    continue;
                }

                $descricao = mb_convert_encoding($registro['descricao'], 'UTF-8', 'ISO-8859-1');
                $descricao2 = mb_convert_encoding($registro['descricao2'], 'UTF-8', 'ISO-8859-1');
                $descricao3 = mb_convert_encoding($registro['descricao3'], 'UTF-8', 'ISO-8859-1');
                $original = mb_convert_encoding($registro['original'], 'UTF-8', 'ISO-8859-1');
                $secundario = mb_convert_encoding($registro['secundario'], 'UTF-8', 'ISO-8859-1');
                $aplicacao = mb_convert_encoding($registro['aplicacao'], 'UTF-8', 'ISO-8859-1');

                Produto::updateOrCreate(
                    ['codigo' => $codigo],
                    [
                        'descricao' => $descricao ?? null,
                        'descricao2' => $descricao2 ?? null,
                        'descricao3' => $descricao3 ?? null,
                        'original' => $original ?? null,
                        'secundario' => $secundario ?? null,
                        'aplciacao' => $aplicacao ?? null,
                        'localizacao' => $registro['localizacao'] ?? null,
                        'diversa' => $registro['diversa'] ?? null,
                        'unidadeMedida' => $registro['unidademedida'] ?? null,
                    ]
                );
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('erro', 'Ocorreu um erro ao processar o arquivo: ' . $e->getMessage());
        }
        return redirect()->back()->with('sucesso', 'Produtos importados e atualizados com sucesso!');
    }
}