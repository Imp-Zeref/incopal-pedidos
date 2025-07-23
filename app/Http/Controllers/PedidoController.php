<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\TipoPedido;
use App\Models\StatusPedido;
use App\Http\Requests\StorePedidoRequest;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $pedidos = Pedido::where('fk_usuario', $usuario->id)
                         ->with(['statusPedido', 'cliente', 'tipoPedido'])
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

        $user = $request->user();
        if ($user->id !== $pedido->fk_usuario && $user->tipoUsuario->nome !== 'Administrador') {
            abort(403, 'Acesso não autorizado.');
        }

        return view('pedidos.show', compact('pedido'));
    }
}