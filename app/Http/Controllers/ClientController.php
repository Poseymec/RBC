<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function home()
    {
        $sliders = Slider::where('status', 1)->get();

        $categories = Category::with(['products' => function ($query) {
            $query->where('status', 1)->with(['avis' => function ($q) {
                $q->select('product_id', DB::raw('MAX(rating) as max_rating'))
                    ->groupBy('product_id');
            }]);
        }])->get();

        $user = Auth::user();
        $bienvenu = '';

        if ($user) {
            $bienvenu = 'Bienvenue, ' . $user->name;
        }

        if (!Session::has('bienvenu_displayed') && !empty($bienvenu)) {
            Session::flash('bienvenu', $bienvenu);
            Session::put('bienvenu_displayed', true);
        }

        return view('client.home', compact('sliders', 'categories'));
    }

    // 🔥 Méthode store refondue : recherche + filtrage + pagination
    public function store(Request $request)
    {
        // Récupérer les paramètres
        $searchTerm = $request->input('q');
        $selectedCategory = $request->input('category');

        // Charger toutes les catégories avec le nombre de produits actifs (pour le filtre)
        $categories = Category::withCount(['products as active_product_count' => function ($query) {
            $query->where('status', 1);
        }])->get();

        // Requête de base : produits actifs avec relation catégorie
        $productsQuery = Product::where('status', 1);

        // Appliquer la recherche
        if ($searchTerm) {
            $productsQuery->where(function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', "%{$searchTerm}%")
                    ->orWhere('product_description', 'like', "%{$searchTerm}%");
            });
        }

        // Appliquer le filtre par catégorie
        if ($selectedCategory) {
            $productsQuery->where('category_id', $selectedCategory);
        }

        // Paginer les résultats (6 par page)
        $products = $productsQuery->paginate(6)->appends($request->only(['q', 'category']));

        // Compter le total des produits filtrés
        $totalProducts = $products->total();

        return view('client.store', compact('products', 'categories', 'searchTerm', 'selectedCategory', 'totalProducts'));
    }

    public function productdetail($id)
    {
        $product = Product::findOrFail($id);
        $promotion = Promotion::find($id); // ⚠️ Vérifie si cette logique est correcte (Promotion::find($id) ?)
        $higthRating = $product->avis()->max('rating');
        $productAvis1 = $product->avis;

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('status', 1)
            ->where('id', '!=', $product->id)
            ->with(['avis' => function ($q) {
                $q->select('product_id', DB::raw('MAX(rating) as max_rating'))
                    ->groupBy('product_id');
            }])
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('client.productdetail', compact(
            'product',
            'relatedProducts',
            'promotion',
            'higthRating',
            'productAvis1'
        ));
    }

    public function checkout()
    {
        return view('client.checkout');
    }

    // 🔍 Ancienne recherche (tu peux la garder ou la supprimer)
    public function rechercheclient(Request $request)
    {
        $recherche = $request->input('mot');
        $resultatProduct = Product::where('product_name', 'LIKE', "%$recherche%")
            ->orWhere('product_description', 'LIKE', "%$recherche%")
            ->get();
        $resultatPromo = Promotion::where('description1', 'LIKE', "%$recherche%")
            ->orWhere('description2', 'LIKE', "%$recherche%")
            ->get();

        return view('client.resultat', compact('resultatPromo', 'resultatProduct'));
    }
}
