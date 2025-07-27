<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\StatusPedido;
use App\Models\StatusProdutoPedido;
use App\Models\TipoPedido;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PedidoCreate extends Component
{
    public $clienteId;
    public $clienteNome = 'Nenhum';
    public $tipoPedidoId;
    public $dtPrevisao;
    public $observacao;
    public $urgente = false;

    public $orderItems = [];

    public $showClienteSearchModal = false;
    public $showProductSearchModal = false;

    public $clienteSearch = '';
    public $produtoSearch = '';

    protected $rules = [
        'tipoPedidoId' => 'required|exists:tipo_pedidos,id',
        'clienteId' => 'nullable|exists:clientes,id',
        'dtPrevisao' => 'nullable|date',
        'orderItems' => 'required|array|min:1',
        'orderItems.*.codigo' => 'required|exists:produtos,codigo',
        'orderItems.*.quantidade' => 'required|numeric|min:1',
    ];

    protected $messages = [
        'orderItems.required' => 'É necessário adicionar pelo menos um produto ao pedido.',
    ];

    protected $validationAttributes = [
        'tipoPedidoId' => 'tipo de pedido',
        'orderItems.*.codigo' => 'código do produto',
        'orderItems.*.quantidade' => 'quantidade',
    ];

    public function removeOrderItem($index)
    {
        unset($this->orderItems[$index]);
        $this->orderItems = array_values($this->orderItems);
    }

    public function updatedOrderItems($value, $key)
    {
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'codigo' && !empty($value)) {
            $produto = Produto::where('codigo', strtoupper($value))->first();
            if ($produto) {
                $this->orderItems[$index]['descricao'] = $produto->descricao;
                $this->orderItems[$index]['original'] = $produto->original;
                $this->orderItems[$index]['secundario'] = $produto->secundario;
                $this->orderItems[$index]['produto_id'] = $produto->id;
            } else {
                $this->orderItems[$index]['descricao'] = 'Código não encontrado';
                $this->orderItems[$index]['original'] = '';
                $this->orderItems[$index]['secundario'] = '';
                $this->orderItems[$index]['produto_id'] = null;
            }
        }
    }

    public function selectCliente($clienteId, $clienteNome)
    {
        $this->clienteId = $clienteId;
        $this->clienteNome = $clienteNome;
        $this->closeClienteSearchModal();
    }

    public function clearCliente()
    {
        $this->clienteId = null;
        $this->clienteNome = 'Nenhum';
    }

    public function selectProduct($codigo)
    {
        $produto = Produto::where('codigo', $codigo)->first();
        if (!$produto) return;

        $emptyItemIndex = -1;
        foreach ($this->orderItems as $index => $item) {
            if (empty($item['codigo'])) {
                $emptyItemIndex = $index;
                break;
            }
        }

        if ($emptyItemIndex !== -1) {
            $this->orderItems[$emptyItemIndex]['codigo'] = $produto->codigo;
            $this->orderItems[$emptyItemIndex]['descricao'] = $produto->descricao;
            $this->orderItems[$emptyItemIndex]['original'] = $produto->original;
            $this->orderItems[$emptyItemIndex]['secundario'] = $produto->secundario;
            $this->orderItems[$emptyItemIndex]['produto_id'] = $produto->id;
        } else {
            $this->orderItems[] = [
                'codigo' => $produto->codigo,
                'descricao' => $produto->descricao,
                'original' => $produto->original,
                'secundario' => $produto->secundario,
                'quantidade' => 1,
                'produto_id' => $produto->id,   
            ];
        }

        $this->closeProductSearchModal();
    }

    public function criarPedido()
    {
        $this->validate();

        $pedido = Pedido::create([
            'fk_cliente' => $this->clienteId,
            'fk_tipo_pedido' => $this->tipoPedidoId,
            'dt_previsao' => $this->dtPrevisao,
            'observacao' => $this->observacao,
            'urgente' => $this->urgente,
            'fk_usuario' => Auth::id(),
            'fk_status_pedido' => StatusPedido::where('nome', 'Pendente')->firstOrFail()->id,
        ]);

        $statusProdutoPendente = StatusProdutoPedido::where('nome', 'Pendente')->firstOrFail();

        foreach ($this->orderItems as $item) {
            if (!empty($item['produto_id'])) {
                $pedido->produtos()->attach($item['produto_id'], [
                    'quantidade' => $item['quantidade'],
                    'fk_status_produto' => $statusProdutoPendente->id
                ]);
            }
        }

        return redirect()->route('pedidos.show', $pedido->id);
    }

    public function openClienteSearchModal()
    {
        $this->showClienteSearchModal = true;
    }
    public function closeClienteSearchModal()
    {
        $this->showClienteSearchModal = false;
        $this->clienteSearch = '';
    }
    public function openProductSearchModal()
    {
        $this->showProductSearchModal = true;
    }
    public function closeProductSearchModal()
    {
        $this->showProductSearchModal = false;
        $this->produtoSearch = '';
    }

    public function render()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $tiposPedido = TipoPedido::all();
        $clienteResults = [];
        $produtoResults = [];

        if ($this->showClienteSearchModal) {
            $query = Cliente::query();
            if (strlen($this->clienteSearch) >= 2) {
                $query->whereRaw("unaccent(lower(nome)) LIKE unaccent(lower(?))", ['%' . $this->clienteSearch . '%']);
            }
            $clienteResults = $query->orderBy('nome')->take(10)->get();
        }
        
        if ($this->showProductSearchModal) {
            $query = Produto::query();
            if (strlen($this->produtoSearch) >= 2) {
                $searchString = implode(' & ', explode(' ', $this->produtoSearch)) . ':*';
                $query->whereRaw("search_vector @@ to_tsquery('portuguese', unaccent(?))", [$searchString]);
            }
            $produtoResults = $query->orderBy('codigo')->take(20)->get();
        }

        return view('livewire.pedido-create', [
            'clientes' => $clientes,
            'tiposPedido' => $tiposPedido,
            'clienteResults' => $clienteResults,
            'produtoResults' => $produtoResults,
        ]);
    }
}
