<?php

namespace App\Http\Controllers;

use App\Models\BlocoNotas;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlocoNotasController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $blocos = Auth::user()->blocoNotas()->latest()->get();
        return view('bloco_notas.index', compact('blocos'));
    }

    public function create()
    {
        return view('bloco_notas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['titulo' => 'required|string|max:255']);
        $bloco = Auth::user()->blocoNotas()->create($validated);
        
        return redirect()->route('bloco-notas.show', $bloco);
    }

    public function show(BlocoNotas $blocoNota)
    {
        $this->authorize('view', $blocoNota);
        $blocoNota->load('produtos');
        $produtosDisponiveis = Produto::orderBy('codigo')->get(['id', 'codigo', 'descricao']);
        return view('bloco_notas.show', compact('blocoNota', 'produtosDisponiveis'));
    }

    public function update(Request $request, BlocoNotas $blocoNota)
    {
        $this->authorize('update', $blocoNota);
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'nome_cliente' => 'nullable|string|max:255',
            'anotacoes' => 'nullable|string',
        ]);
        $blocoNota->update($validated);
        return redirect()->route('bloco-notas.show', $blocoNota)->with('sucesso', 'Anotação salva!');
    }

    public function destroy(BlocoNotas $blocoNota)
    {
        $this->authorize('delete', $blocoNota);
        $blocoNota->delete();
        return redirect()->route('bloco-notas.index')->with('sucesso', 'Anotação excluída!');
    }

    public function addProduct(Request $request, BlocoNotas $blocoNota)
    {
        $this->authorize('update', $blocoNota);
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        if ($blocoNota->produtos()->where('produto_id', $validated['produto_id'])->exists()) {
            $produtoExistente = $blocoNota->produtos()->find($validated['produto_id']);
            $novaQuantidade = $produtoExistente->pivot->quantidade + $validated['quantidade'];
            $blocoNota->produtos()->updateExistingPivot($validated['produto_id'], ['quantidade' => $novaQuantidade]);
        } else {
            $blocoNota->produtos()->attach($validated['produto_id'], ['quantidade' => $validated['quantidade']]);
        }
        return redirect()->route('bloco-notas.show', $blocoNota);
    }

    public function removeProduct(BlocoNotas $blocoNota, Produto $produto)
    {
        $this->authorize('update', $blocoNota);
        $blocoNota->produtos()->detach($produto->id);
        return redirect()->route('bloco-notas.show', $blocoNota);
    }
}