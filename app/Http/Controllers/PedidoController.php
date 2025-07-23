<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $pedidos = Pedido::where('fk_usuario', $usuario->id)
                         ->with(['statusPedido', 'cliente', 'tipoPedido'])
                         ->latest()
                         ->paginate(15);

        return view('pedidos.index', compact('pedidos'));
    }
}