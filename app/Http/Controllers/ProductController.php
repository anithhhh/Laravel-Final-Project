<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $p = Product::orderBy('created_at', 'DESC')->get();

        return view('products.list', ['products' => $p]);
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $r) {
        $v = Validator::make($r->all(), [
            'name' => 'required|min:3',
            'price' => 'required|numeric',
        ]);

        if ($v->fails()) {
          return redirect(
                    )->route('products.create')->withInput()->withErrors($v);
        }
        $p= new Product();
        $p->name = $r->name;
        $p->price = $r->price;
        $p->description = $r->description;
        $p->save();
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function edit($id) {
        $p = Product::findOrFail($id);

        return view('products.edit', ['product'=>$p]);
    }

    public function update($id, Request $r) {
        $p = Product::findOrFail($id);
        $v = Validator::make($r->all(), [
            'name' => 'required|min:3',
            'price' => 'required|numeric',
        ]);

        if ($v->fails()) {
          return redirect(
                    )->route('products.edit', $p->id)->withInput()->withErrors($v);
        }
        $p->name = $r->name;
        $p->price = $r->price;
        $p->description = $r->description;
        $p->save();
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy() {
        $p = Product::findOrFail($id);

        $p->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
