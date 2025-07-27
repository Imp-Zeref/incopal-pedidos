<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class FreteCalculator extends Component
{
    public $cepOrigem = '';
    public $cepDestino = '';
    public $peso = 1;
    public $altura = 10;
    public $largura = 15;
    public $comprimento = 20;

    public $cotacoes = [];
    public $erro = null;

    protected $rules = [
        'cepOrigem' => 'required|digits:8',
        'cepDestino' => 'required|digits:8',
        'peso' => 'required|numeric|min:0.1',
        'altura' => 'required|numeric|min:1',
        'largura' => 'required|numeric|min:1',
        'comprimento' => 'required|numeric|min:1',
    ];

    protected $validationAttributes = [
        'cepOrigem' => 'CEP de Origem',
        'cepDestino' => 'CEP de Destino',
    ];

    public function calcularFrete()
    {
        $this->validate();
        $this->erro = null;
        $this->cotacoes = [];

        $token = config('services.melhor_envio.token');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post('https://www.melhorenvio.com.br/api/v2/me/shipment/calculate', [
            'from' => ['postal_code' => $this->cepOrigem],
            'to' => ['postal_code' => $this->cepDestino],
            'package' => [
                'weight' => $this->peso,
                'width' => $this->largura,
                'height' => $this->altura,
                'length' => $this->comprimento,
            ],
        ]);

        if ($response->successful()) {
            $this->cotacoes = $response->json();
        } else {
            $this->erro = $response->json('message', 'Não foi possível calcular o frete. Verifique os dados e tente novamente.');
        }
    }

    public function render()
    {
        return view('livewire.frete-calculator');
    }
}