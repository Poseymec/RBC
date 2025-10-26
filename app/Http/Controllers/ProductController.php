<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Enregistrer un nouveau produit
     */
    public function saveproduct(Request $request)
    {
        // Validation avec messages personnalisés
        $validator = Validator::make($request->all(), [
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_promo'       => 'required|numeric|min:0',
            'product_reduction'   => 'required|numeric|min:0|max:100',
            'product_brand'       => 'nullable|string|max:255',
            'product_description' => 'required|string',
            'product_category'    => 'required|string',
            'cover'               => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'cover.required' => 'L’image de couverture est obligatoire.',
            'cover.image'    => 'Le fichier de couverture doit être une image valide.',
            'cover.max'      => 'L’image de couverture ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que la catégorie existe
        $category = Category::where('category_name', $request->input('product_category'))->first();
        if (!$category) {
            return back()->withErrors(['product_category' => 'La catégorie sélectionnée est invalide.'])->withInput();
        }

        // Gérer l'image de couverture
        $coverNameToSave = null;
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $coverNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product_cover', $coverNameToSave);
        }

        // Créer le produit
        $product = new Product();
        $product->product_name        = $request->input('product_name');
        $product->product_price       = $request->input('product_price');
        $product->product_promo       = $request->input('product_promo');
        $product->product_reduction   = $request->input('product_reduction');
        $product->product_brand       = $request->filled('product_brand') ? $request->input('product_brand') : 'Nouveau';
        $product->product_description = $request->input('product_description');
        $product->product_category    = $request->input('product_category');
        $product->cover               = $coverNameToSave;
        $product->category_id         = $category->id;
        $product->save();

        // Gérer les images supplémentaires
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/products_images', $fileNameToSave);

                ProductImage::create([
                    'images'    => $fileNameToSave,
                    'product_id' => $product->id,
                ]);
            }
        }

        return back()->with('status', 'Produit enregistré avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function editeproduct($id)
    {
        $product = Product::with('product_images')->find($id);
        if (!$product) {
            return redirect()->back()->withErrors(['Produit introuvable.']);
        }

        $categories = Category::all();
        return view('admin.editeproduct', compact('product', 'categories'));
    }

    /**
     * Activer un produit
     */
    public function activateproduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->withErrors(['Produit non trouvé.']);
        }
        $product->status = 1;
        $product->save();
        return back();
    }

    /**
     * Désactiver un produit
     */
    public function unactivateproduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->withErrors(['Produit non trouvé.']);
        }
        $product->status = 0;
        $product->save();
        return back();
    }

    /**
     * Afficher la page de confirmation de suppression
     */
    public function deleteproduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.product')->withErrors(['Produit non trouvé.']);
        }
        return view('admin.deleteproduct', compact('product'));
    }

    /**
     * Supprimer définitivement un produit
     */
    public function yesdeleteproduct($id)
    {
        $product = Product::with('product_images')->find($id);
        if (!$product) {
            return redirect()->route('admin.product')->withErrors(['Produit non trouvé.']);
        }

        // Supprimer l'image de couverture
        if ($product->cover) {
            Storage::delete("public/product_cover/{$product->cover}");
        }

        // Supprimer les images supplémentaires
        foreach ($product->product_images as $image) {
            Storage::delete("public/products_images/{$image->images}");
            $image->delete();
        }

        $product->delete();
        return redirect()->route('admin.product')->with('status', 'Produit supprimé avec succès.');
    }

    /**
     * Afficher la confirmation de suppression d'une image
     */
    public function deleteproductimage($id)
    {
        $productimage = ProductImage::find($id);
        if (!$productimage) {
            return back()->withErrors(['Image non trouvée.']);
        }
        return view('admin.deleteproductimage', compact('productimage'));
    }

    /**
     * Supprimer une image spécifique
     */
    public function yesdeleteproductimage($id)
    {
        $productimage = ProductImage::find($id);
        if (!$productimage) {
            return back()->withErrors(['Image non trouvée.']);
        }

        Storage::delete("public/products_images/{$productimage->images}");
        $productId = $productimage->product_id;
        $productimage->delete();

        return redirect()->route('admin.editeproduct', $productId)->with('status', 'Image supprimée avec succès.');
    }

    /**
     * Mettre à jour un produit
     */
    public function updateproduct($id, Request $request)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->withErrors(['Produit non trouvé.']);
        }

        $validator = Validator::make($request->all(), [
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_promo'       => 'required|numeric|min:0',
            'product_reduction'   => 'required|numeric|min:0|max:100',
            'product_brand'       => 'nullable|string|max:255',
            'product_description' => 'required|string',
            'product_category'    => 'required|string',
            'cover'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'cover.image' => 'Le fichier de couverture doit être une image valide.',
            'cover.max'   => 'L’image de couverture ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier la catégorie
        $category = Category::where('category_name', $request->input('product_category'))->first();
        if (!$category) {
            return back()->withErrors(['product_category' => 'Catégorie invalide.'])->withInput();
        }

        // Mettre à jour les champs simples
        $product->fill([
            'product_name'        => $request->input('product_name'),
            'product_price'       => $request->input('product_price'),
            'product_promo'       => $request->input('product_promo'),
            'product_reduction'   => $request->input('product_reduction'),
            'product_brand'       => $request->filled('product_brand') ? $request->input('product_brand') : 'Nouveau',
            'product_description' => $request->input('product_description'),
            'product_category'    => $request->input('product_category'),
            'category_id'         => $category->id,
        ]);

        // Gérer la nouvelle image de couverture
        if ($request->hasFile('cover')) {
            // Supprimer l’ancienne
            if ($product->cover) {
                Storage::delete("public/product_cover/{$product->cover}");
            }
            // Enregistrer la nouvelle
            $file = $request->file('cover');
            $coverNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product_cover', $coverNameToSave);
            $product->cover = $coverNameToSave;
        }

        // Ajouter de nouvelles images (sans supprimer les anciennes)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $fileNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/products_images', $fileNameToSave);

                ProductImage::create([
                    'images'    => $fileNameToSave,
                    'product_id' => $product->id,
                ]);
            }
        }

        $product->save();
        return redirect()->route('admin.product')->with('status', 'Produit mis à jour avec succès.');
    }
}
