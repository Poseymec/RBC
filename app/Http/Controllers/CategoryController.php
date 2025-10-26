<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function savecategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
        ]);

        Category::create([
            'category_name' => $request->input('category_name'),
        ]);

        return back()->with('status', 'Catégorie créée avec succès.');
    }

    // 🔥 Nouvelle méthode : suppression directe (AJAX compatible)
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Optionnel : vérifier qu'aucun produit n'est associé
        if ($category->products()->count() > 0) {
            return response()->json([
                'error' => 'Impossible de supprimer cette catégorie : elle contient des produits.'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'success' => 'Catégorie supprimée avec succès.'
        ]);
    }

    public function editecategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.editecategory', compact('category'));
    }

    public function updatecategory($id, Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->category_name = $request->input('category_name');
        $category->save();

        return redirect()->route('admin.category')->with('status', 'Catégorie modifiée avec succès.');
    }
}
