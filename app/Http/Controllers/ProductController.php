<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $p = Product::orderBy('created_at', 'DESC')->get();

        return view('products.list', ['products' => $p]);
    }

    public function create() {
        return view('products.create', ['categories' => Category::all()]);
    }

    public function store(Request $r) {
        $v = Validator::make($r->all(), [
            'category' => 'required',
            'name' => 'required|min:3',
            'price' => 'required|numeric',
        ]);

        if ($v->fails()) {
            return redirect(
                )->route('products.create')->withInput()->withErrors($v);
        }
        $c = Category::findOrFail($r->category);
        $p = new Product();
        $p->name = $r->name;
        $p->price = $r->price;
        $p->description = $r->description;
        $p->category_id = $c->id;
        $p->save();
        $c->save([$p]);
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function edit($id) {
        $p = Product::findOrFail($id);

        return view('products.edit', ['product' => $p, 'categories' => Category::all()]);
    }

    public function update($id, Request $r) {
        $p = Product::findOrFail($id);
        $v = Validator::make($r->all(), [
            'category' => 'required',
            'name' => 'required|min:3',
            'price' => 'required|numeric',
        ]);

        if ($v->fails()) {
            return redirect(
                )->route('products.create')->withInput()->withErrors($v);
        }
        $c = Category::findOrFail($r->category);
        $p->name = $r->name;
        $p->price = $r->price;
        $p->description = $r->description;
        $p->category_id = $c->id;
        $p->save();
        $c->save([$p]);
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function destroy($id) {
        $p = Product::findOrFail($id);

        $p->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
