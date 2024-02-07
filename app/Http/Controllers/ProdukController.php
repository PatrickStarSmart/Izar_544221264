<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{

    public function index(): View
    {
        $produks = Produk::latest()->paginate(3);

        return view('produks.index',compact('produks'))
                    ->with('i', (request()->input('page', 1) - 1) * 3);
    }

    public function create(): View
    {
        return view('produks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
        ]);

        $input = $request->all();

        Produk::create($input);

        return redirect()->route('produks.index')
                        ->with('success','Product created successfully.');
    }

    public function edit(Produk $produk): View
    {
        return view('produks.edit',compact('produk'));
    }

    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required'
        ]);

        $input = $request->all();

        $produk->update($input);

        return redirect()->route('produks.index')
                        ->with('success','Product has been updated successfully.');
    }

    public function destroy(Produk $produk): RedirectResponse
    {
        $produk->delete();

        return redirect()->route('produks.index')
                        ->with('success','Product has been deleted successfully.');
    }
}
