<?php

namespace App\Http\Controllers;

use App\Models\Racao;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index()
    {
        $racoes = Racao::all();
        return view('estoque.index', compact('racoes'));
    }

    public function create()
    {
        return view('estoque.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'quantidade' => 'required|integer|min:0',
            // Adicione outras validações necessárias
        ]);

        Racao::create($request->all());

        return redirect()->route('estoque.index')->with('success', 'Item de estoque criado com sucesso.');
    }

    public function edit(Racao $racao)
    {
        return view('estoque.edit', compact('racao'));
    }

    public function update(Request $request, Racao $racao)
    {
        $request->validate([
            'nome' => 'required',
            'quantidade' => 'required|integer|min:0',
            // Adicione outras validações necessárias
        ]);

        $racao->update($request->all());

        return redirect()->route('estoque.index')->with('success', 'Item de estoque atualizado com sucesso.');
    }

    public function destroy(Racao $racao)
    {
        $racao->delete();
        return redirect()->route('estoque.index')->with('success', 'Item de estoque excluído com sucesso.');
    }

    public function baixar(Racao $racao)
    {
        // Lógica para dar baixa no item de estoque
        $novaQuantidade = $racao->quantidade - 1; // Exemplo: diminui 1 da quantidade
        if ($novaQuantidade >= 0) {
            $racao->update(['quantidade' => $novaQuantidade]);
            return redirect()->route('estoque.index')->with('success', 'Baixa realizada com sucesso.');
        } else {
            return redirect()->route('estoque.index')->with('error', 'Quantidade insuficiente para baixa.');
        }
    }
}
