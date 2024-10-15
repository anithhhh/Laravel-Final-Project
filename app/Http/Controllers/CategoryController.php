<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $c = Category::orderBy('created_at', 'DESC')->get();

        return view('categories.list', ['categories' => $c]);
    }

    public function create() {
        return view('categories.create');
    }

    public function store(Request $r) {
        $v = Validator::make($r->all(), [
            'name' => 'required|unique:categories|min:3',
        ]);

        if ($v->fails()) {
            return redirect(
                )->route('categories.create')->withInput()->withErrors($v);
        }
        $c= new Category();
        $c->name = $r->name;
        $c->description = $r->description;
        $c->save();
        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function edit($id) {
        $c = Category::findOrFail($id);

        return view('categories.edit', ['category' => $c]);
    }

    public function update($id, Request $r) {
        $c = Category::findOrFail($id);
        $v = Validator::make($r->all(), [
            'name' => 'required|min:3',
        ]);

        if ($v->fails()) {
            return redirect(
                )->route('categories.edit', $c->id)->withInput()->withErrors($v);
        }
        $c->name = $r->name;
        $c->description = $r->description;
        $c->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id) {
        $c = Category::findOrFail($id);

        foreach ($c->products as $p) {
            $p->delete();
        }
        $c->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
