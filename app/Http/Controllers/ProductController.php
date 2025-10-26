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
    public function saveproduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_promo'       => 'required|numeric|min:0',
            'product_reduction'   => 'nullable|numeric|min:0|max:100',
            'product_brand'       => 'nullable',
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

        $category = Category::where('category_name', $request->input('product_category'))->first();
        if (!$category) {
            return back()->withErrors(['product_category' => 'La catégorie sélectionnée est invalide.'])->withInput();
        }

        $coverNameToSave = null;
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $coverNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product_cover', $coverNameToSave);
        }

        $product = Product::create([
            'product_name'        => $request->input('product_name'),
            'product_price'       => $request->input('product_price'),
            'product_promo'       => $request->input('product_promo'),
            'product_reduction'   => $request->input('product_reduction'),
            'product_brand'       => $request->filled('product_brand') ? 'Nouveau' : null,
            'product_description' => $request->input('product_description'),
            'product_category'    => $request->input('product_category'),
            'cover'               => $coverNameToSave,
            'category_id'         => $category->id,
            'status'              => 1,
        ]);

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

    public function editeproduct($id)
    {
        $product = Product::with('product_images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.editeproduct', compact('product', 'categories'));
    }

    public function updateproduct($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_promo'       => 'required|numeric|min:0',
            'product_reduction'   => 'nullable|numeric|min:0|max:100',
            'product_brand'       => 'nullable',
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

        $category = Category::where('category_name', $request->input('product_category'))->first();
        if (!$category) {
            return back()->withErrors(['product_category' => 'Catégorie invalide.'])->withInput();
        }

        $product->fill([
            'product_name'        => $request->input('product_name'),
            'product_price'       => $request->input('product_price'),
            'product_promo'       => $request->input('product_promo'),
            'product_reduction'   => $request->input('product_reduction'),
            'product_brand'       => $request->filled('product_brand') ? 'Nouveau' : null,
            'product_description' => $request->input('product_description'),
            'product_category'    => $request->input('product_category'),
            'category_id'         => $category->id,
        ]);

        if ($request->hasFile('cover')) {
            if ($product->cover) {
                Storage::delete("public/product_cover/{$product->cover}");
            }
            $file = $request->file('cover');
            $coverNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product_cover', $coverNameToSave);
            $product->cover = $coverNameToSave;
        }

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
        return redirect()->route('admin.editeproduct', $id)->with('status', 'Produit mis à jour avec succès.');
    }

    public function activateproduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 1;
        $product->save();
        return back();
    }

    public function unactivateproduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 0;
        $product->save();
        return back();
    }

    public function deleteproduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.deleteproduct', compact('product'));
    }

    public function yesdeleteproduct($id)
    {
        $product = Product::with('product_images')->findOrFail($id);

        if ($product->cover) {
            Storage::delete("public/product_cover/{$product->cover}");
        }

        foreach ($product->product_images as $image) {
            Storage::delete("public/products_images/{$image->images}");
            $image->delete();
        }

        $product->delete();
        return redirect()->route('admin.product')->with('status', 'Produit supprimé avec succès.');
    }

    // 🔥 Nouvelle méthode : suppression directe d'image
    public function destroyProductImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;

        if (Storage::exists("public/products_images/{$image->images}")) {
            Storage::delete("public/products_images/{$image->images}");
        }

        $image->delete();

        return redirect()->route('admin.editeproduct', $productId)
            ->with('status', 'Image supprimée avec succès.');
    }
}
