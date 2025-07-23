<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\TipoPedido;
use App\Models\StatusPedido;
use App\Http\Requests\StorePedidoRequest;
use App\Models\Produto;
use App\Models\StatusProdutoPedido;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PedidoController extends Controller
{
    use AuthorizesRequests;
    
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

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $tiposPedido = TipoPedido::all();

        return view('pedidos.create', compact('clientes', 'tiposPedido'));
    }

    public function store(StorePedidoRequest $request)
    {
        $dadosValidados = $request->validated();

        $dadosValidados['fk_usuario'] = $request->user()->id;
        $dadosValidados['urgente'] = $request->has('urgente');

        $statusPendente = StatusPedido::where('nome', 'Pendente')->firstOrFail();
        $dadosValidados['fk_status_pedido'] = $statusPendente->id;

        $pedido = Pedido::create($dadosValidados);

        return redirect()->route('pedidos.show', $pedido)->with('sucesso', 'Pedido criado com sucesso!');
    }

    public function show(Request $request, Pedido $pedido)
    {
        $pedido->load('usuario', 'cliente', 'statusPedido', 'tipoPedido', 'produtos');
        $produtos = Produto::orderBy('nome')->get();

        $statusDisponiveis = StatusPedido::whereIn('nome', ['Encomendado', 'Concluído', 'Não Cotado'])->get();

        $user = $request->user();
        if ($user->id !== $pedido->fk_usuario && $user->tipoUsuario->nome !== 'Administrador') {
            abort(403, 'Acesso não autorizado.');
        }

        return view('pedidos.show', compact('pedido', 'produtos', 'statusDisponiveis'));
    }

    public function addProduct(Request $request, Pedido $pedido)
    {
        $user = $request->user();
        if ($user->id !== $pedido->fk_usuario && $user->tipoUsuario->nome !== 'Administrador') {
            abort(403, 'Acesso não autorizado.');
        }

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
        $this->authorize('changeStatus', $pedido);

        $dadosValidados = $request->validate([
            'fk_status_pedido' => 'required|exists:status_pedidos,id'
        ]);

        $pedido->update([
            'fk_status_pedido' => $dadosValidados['fk_status_pedido']
        ]);

        return redirect()->route('pedidos.show', $pedido)->with('sucesso', 'Status do pedido atualizado!');
    }

    public function cancel(Request $request, Pedido $pedido)
    {
        if ($request->user()->id !== $pedido->fk_usuario) {
            abort(403, 'Ação não autorizada.');
        }

        if ($pedido->statusPedido->nome !== 'Pendente') {
            return redirect()->route('pedidos.show', $pedido)->with('erro', 'Este pedido não pode mais ser cancelado.');
        }

        $statusCancelado = StatusPedido::where('nome', 'Cancelado')->firstOrFail();
        $pedido->update(['fk_status_pedido' => $statusCancelado->id]);

        return redirect()->route('pedidos.show', $pedido)->with('sucesso', 'Pedido cancelado com sucesso.');
    }
}
