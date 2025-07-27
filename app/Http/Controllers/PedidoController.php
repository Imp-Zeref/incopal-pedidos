<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;
use App\Models\StatusPedido;
use App\Models\StatusProdutoPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Cliente;
use App\Models\TipoPedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();
        $query = Pedido::query();

        if ($usuario->tipoUsuario->nome !== 'Administrador') {
            $query->where('fk_usuario', $usuario->id);
        }

        $pedidos = $query->with(['statusPedido', 'cliente', 'tipoPedido', 'usuario'])
                         ->latest()
                         ->paginate(15);

        return view('pedidos.index', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipoPedidoId' => 'required|exists:tipo_pedidos,id',
            'clienteId' => 'nullable|exists:clientes,id',
            'dtPrevisao' => 'nullable|date',
            'observacao' => 'nullable|string',
            'orderItems' => 'required|array|min:1',
            'orderItems.*.produto_id' => 'required|exists:produtos,id',
            'orderItems.*.quantidade' => 'required|numeric|min:1',
        ], [
            'orderItems.required' => 'É necessário adicionar pelo menos um produto ao pedido.',
            'orderItems.*.produto_id.required' => 'O código do produto na linha :index é inválido ou não foi encontrado.',
        ]);

        $pedido = Pedido::create([
            'fk_cliente' => $validated['clienteId'],
            'fk_tipo_pedido' => $validated['tipoPedidoId'],
            'dt_previsao' => $validated['dtPrevisao'],
            'observacao' => $validated['observacao'],
            'fk_usuario' => Auth::id(),
            'fk_status_pedido' => StatusPedido::where('nome', 'Pendente')->firstOrFail()->id,
        ]);

        $statusProdutoPendente = StatusProdutoPedido::where('nome', 'Pendente')->firstOrFail();

        foreach ($validated['orderItems'] as $item) {
            $pedido->produtos()->attach($item['produto_id'], [
                'quantidade' => $item['quantidade'],
                'fk_status_produto' => $statusProdutoPendente->id
            ]);
        }

        return redirect()->route('pedidos.show', $pedido)->with('sucesso', 'Pedido criado com sucesso!');
    }

    public function show(Pedido $pedido)
    {
        Gate::authorize('view', $pedido);
        $pedido->load('usuario', 'cliente', 'statusPedido', 'tipoPedido', 'produtos.statusProduto');
        $produtosDisponiveis = Produto::orderBy('codigo')->get(); 
        
        $statusDisponiveis = StatusPedido::whereIn('nome', ['Encomendado', 'Concluído', 'Não Cotado'])->get();

        return view('pedidos.show', compact('pedido', 'produtosDisponiveis', 'statusDisponiveis'));
    }

    public function edit(Pedido $pedido)
    {
        Gate::authorize('update', $pedido);
    }
    
    public function update(Request $request, Pedido $pedido)
    {
        Gate::authorize('update', $pedido);
    }

    public function addProduct(Request $request, Pedido $pedido)
    {
        Gate::authorize('addProduct', $pedido);
        $dadosValidados = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|numeric|min:0.01',
        ]);
        $statusPendente = StatusProdutoPedido::where('nome', 'Pendente')->firstOrFail();
        $pedido->produtos()->attach($dadosValidados['produto_id'], [
            'quantidade' => $dadosValidados['quantidade'],
            'fk_status_produto' => $statusPendente->id
        ]);
        return redirect()->route('pedidos.show', $pedido)->with('sucesso', 'Produto adicionado com sucesso!');
    }

    public function updateStatus(Request $request, Pedido $pedido)
    {
        Gate::authorize('changeStatus', $pedido);
        $dadosValidados = $request->validate(['fk_status_pedido' => 'required|exists:status_pedidos,id']);
        $pedido->update($dadosValidados);
        return redirect()->route('pedidos.show', $pedido)->with('sucesso', 'Status do pedido atualizado!');
    }

    public function cancel(Request $request, Pedido $pedido)
    {
        Gate::authorize('cancel', $pedido);
        $statusCancelado = StatusPedido::where('nome', 'Cancelado')->firstOrFail();
        $pedido->update(['fk_status_pedido' => $statusCancelado->id]);
        return redirect()->route('pedidos.show', $pedido)->with('sucesso', 'Pedido cancelado com sucesso.');
    }
}