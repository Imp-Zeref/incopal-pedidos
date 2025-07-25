<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Produto;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class ProcessarImportacaoProdutos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function handle(): void
    {
        $fullPath = Storage::path($this->path);

        echo "Verificando existência do arquivo em: $fullPath\n";

        if (!file_exists($fullPath)) {
            echo "Arquivo não encontrado para importação: $fullPath\n";
            return;
        }

        $csv = Reader::createFromPath($fullPath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');

        foreach ($csv->getRecords() as $registro) {
            $codigo = (string) ($registro['codigo'] ?? '');
            if (empty(trim($codigo))) {
                continue;
            }

            $descricao = isset($registro['descricao']) ? mb_convert_encoding($registro['descricao'], 'UTF-8', 'ISO-8859-1') : null;
            $descricao2 = isset($registro['descricao2']) ? mb_convert_encoding($registro['descricao2'], 'UTF-8', 'ISO-8859-1') : null;
            $descricao3 = isset($registro['descricao3']) ? mb_convert_encoding($registro['descricao3'], 'UTF-8', 'ISO-8859-1') : null;
            $original   = isset($registro['original'])   ? mb_convert_encoding($registro['original'],   'UTF-8', 'ISO-8859-1') : null;
            $secundario = isset($registro['secundario']) ? mb_convert_encoding($registro['secundario'], 'UTF-8', 'ISO-8859-1') : null;
            $aplicacao  = isset($registro['aplicacao'])  ? mb_convert_encoding($registro['aplicacao'],  'UTF-8', 'ISO-8859-1') : null;
            $preco      = isset($registro['preco'])      ? mb_convert_encoding($registro['preco'],      'UTF-8', 'ISO-8859-1') : null;

            Produto::updateOrCreate(
                ['codigo' => $codigo],
                [
                    'descricao'       => $descricao,
                    'descricao2'      => $descricao2,
                    'descricao3'      => $descricao3,
                    'original'        => $original,
                    'secundario'      => $secundario,
                    'aplicacao'       => $aplicacao,
                    'localizacao'     => $registro['localizacao']     ?? null,
                    'diversa'         => $registro['diversa']         ?? null,
                    'unidadeMedida'   => $registro['unidademedida']   ?? null,
                    'preco'           => isset($preco) && trim($preco) !== '' ? str_replace(',', '.', trim($preco)) : null,
                ]
            );
        }

        // Remove o arquivo após o processamento
        unlink($fullPath);
    }
}
