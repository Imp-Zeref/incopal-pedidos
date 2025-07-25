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
use Carbon\Carbon;

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
        $csv->setHeaderOffset(3);
        $csv->setDelimiter(';');

        foreach ($csv->getRecords() as $registro) {
            $codigo = (string) ($registro['codigo'] ?? '');
            if (empty(trim($codigo)) || $codigo === 'codigo') {
                continue;
            }

            $precoBruto = $registro['preco'] ?? null;

            if (!empty($precoBruto)) {
                $precoBruto = trim($precoBruto);
                $precoBruto = str_replace('.', '', $precoBruto);
                $precoBruto = str_replace(',', '.', $precoBruto);

                if (is_numeric($precoBruto)) {
                    $precoConvertido = number_format((float)$precoBruto, 2, '.', '');
                } else {
                    echo "Preço inválido: {$precoBruto} no produto código {$codigo}\n";
                    continue;
                }
            } else {
                echo "Preço ausente para o produto código {$codigo}\n";
                continue;
            }

            $estoqueBruto = $registro['estoque'] ?? null;

            if ($estoqueBruto !== null && $estoqueBruto !== ''){
                $estoqueBruto = trim($estoqueBruto);
                $estoqueBruto = str_replace('.', '', $estoqueBruto);
                $estoqueBruto = str_replace(',', '.', $estoqueBruto);

                if (is_numeric($estoqueBruto)) {
                    $estoqueConvertido = number_format((float)$estoqueBruto, 2, '.', '');
                    if( $estoqueConvertido <= 0) {
                        $precoConvertido = 0;
                    }
                } else {
                    echo "Estoque inválido: {$estoqueBruto} no produto código {$codigo}\n";
                    continue;
                }
            } else {
                echo "Estoque ausente para o produto código {$codigo}\n";
                continue;
            }

            $descricao   = isset($registro['descricao'])   ? mb_convert_encoding($registro['descricao'], 'UTF-8', 'ISO-8859-1') : null;
            $descricao2  = isset($registro['descricao2'])  ? mb_convert_encoding($registro['descricao2'], 'UTF-8', 'ISO-8859-1') : null;
            $descricao3  = isset($registro['descricao3'])  ? mb_convert_encoding($registro['descricao3'], 'UTF-8', 'ISO-8859-1') : null;
            $original    = isset($registro['original'])    ? mb_convert_encoding($registro['original'],   'UTF-8', 'ISO-8859-1') : null;
            $secundario  = isset($registro['secundario'])  ? mb_convert_encoding($registro['secundario'], 'UTF-8', 'ISO-8859-1') : null;
            $aplicacao   = isset($registro['aplicacao'])   ? mb_convert_encoding($registro['aplicacao'],  'UTF-8', 'ISO-8859-1') : null;

            $validadeRaw = $registro['validade'] ?? null;
            $validade = null;
            if ($validadeRaw) {
                try {
                    $validade = Carbon::parse(str_replace('/', '-', trim($validadeRaw)))->format('Y-m-d');
                } catch (\Exception $e) {
                    echo "Erro ao converter data: $validadeRaw\n";
                }
            }

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
                    'preco'           => $precoConvertido,
                    'estoque'         => $estoqueConvertido,
                    'validade'        => $validade
                ]
            );
        }

        // Remove o arquivo após o processamento
        unlink($fullPath);
    }
}
