<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\View\View;
use Symfony\Contracts\Service\Attribute\Required;

class ProdutoController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        //
        $produtos = Produto::latest()->paginate(5);
        return view('produtos.idex', compact('produtos'))
         -with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
       return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
     
        $request->validate{[
             'descricao' => 'requered',
             'qtd' => 'required',
             'procoUnitario' => 'required',
             'precoVenda' => 'required',
        
        ]};

        Produto::create($request->all());
        return redirect()->route('produtos.index')
                         ->with('success', 'Produtos criado com sucesso.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto): View
    {
        return view('produtos.show' ,compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produtos
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto): View
    {
        return view('produtos.edit' ,compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produtos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto): RedirectResponse
    {
       $request->validate([
        'descricao' => 'requered',
        'qtd' => 'required',
        'procoUnitario' => 'required',
        'precoVenda' => 'required',

       ]);
       $produto->update($request->all());

       return redirect()->route('produtos.index')
                        ->with('success', 'Produtos atualizado com sucesso.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produtos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto): RedirectResponse
    {
        $produto->delete();

        return redirect()->route('produtos.index')
                        ->with('success', 'Produtos excluído com sucesso.');

    }
}
