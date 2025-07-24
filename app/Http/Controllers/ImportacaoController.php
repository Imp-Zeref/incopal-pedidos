<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use League\Csv\Reader;

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

            $descricao = isset($registro['descricao']) ? mb_convert_encoding($registro['descricao'], 'UTF-8', 'ISO-8859-1') : null;
            $descricao2 = isset($registro['descricao2']) ? mb_convert_encoding($registro['descricao2'], 'UTF-8', 'ISO-8859-1') : null;
            $descricao3 = isset($registro['descricao3']) ? mb_convert_encoding($registro['descricao3'], 'UTF-8', 'ISO-8859-1') : null;
            $original = isset($registro['original']) ? mb_convert_encoding($registro['original'], 'UTF-8', 'ISO-8859-1') : null;
            $secundario = isset($registro['secundario']) ? mb_convert_encoding($registro['secundario'], 'UTF-8', 'ISO-8859-1') : null;
            $aplicacao = isset($registro['aplicacao']) ? mb_convert_encoding($registro['aplicacao'], 'UTF-8', 'ISO-8859-1') : null;
            $preco = isset($registro['preco']) ? mb_convert_encoding($registro['preco'], 'UTF-8', 'ISO-8859-1') : null;

            Produto::updateOrCreate(
                ['codigo' => $codigo],
                [
                    'descricao' => $descricao,
                    'descricao2' => $descricao2,
                    'descricao3' => $descricao3,
                    'original' => $original,
                    'secundario' => $secundario,
                    'aplicacao' => $aplicacao,
                    'localizacao' => $registro['localizacao'] ?? null,
                    'diversa' => $registro['diversa'] ?? null,
                    'unidadeMedida' => $registro['unidademedida'] ?? null,
                    'preco' => isset($preco) && trim($preco) !== ''
                        ? str_replace(',', '.', trim($preco))
                        : null,
                ]
            );
        }

        return redirect()->back()->with('sucesso', 'Produtos importados e atualizados com sucesso!');
    }
}
