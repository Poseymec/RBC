@extends('client_layout.master')

@section('titre')
Produit
@endsection

@section('contenu')

<div class="max-w-7xl mx-auto px-4 py-8 mt-20">
  <h1 class="text-3xl font-bold text-[#E8192C] mb-8">
    Nos Produits
  </h1>

  @if($products->total() === 0 && ($searchTerm || $selectedCategory))
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-12 text-center">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467-.884-6.124-2.364M18 12a6 6 0 11-12 0 6 6 0 0112 0z" />
      </svg>
      <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Aucun produit trouvé</h3>
      <p class="text-gray-500 dark:text-gray-400">Essayez un autre terme ou réinitialisez les filtres.</p>
      <a href="{{ route('store') }}" class="mt-4 inline-block text-[#E8192C] hover:underline">Réinitialiser</a>
    </div>
  @elseif($products->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-12 text-center">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-8m-8 0H4" />
      </svg>
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucun produit disponible</h3>
      <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
        Il n’y a actuellement aucun produit enregistré dans notre catalogue.
      </p>
    </div>
  @else
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Filtres -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Formulaire de recherche et filtres -->
        <form method="GET" class="space-y-6">
          <div>
            <label for="q" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              Rechercher
            </label>
            <input
              id="q"
              name="q"
              type="text"
              value="{{ request('q') }}"
              placeholder="Nom ou description..."
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:border-transparent"
            />
          </div>

          <div class="bg-gray-100 dark:bg-gray-900 p-5 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#E8192C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
              </svg>
              Catégories
            </h2>

            <ul class="space-y-3">
              <li>
                <label class="flex items-center gap-2 p-2 cursor-pointer">
                  <input
                    type="radio"
                    name="category"
                    value=""
                    {{ !request('category') ? 'checked' : '' }}
                    class="accent-[#E8192C]"
                  >
                  <span class="text-gray-800 dark:text-gray-200">Toutes les catégories</span>
                </label>
              </li>
              @foreach ($categories as $categorie)
                @if($categorie->active_product_count > 0)
                  <li>
                    <label class="flex items-center justify-between gap-3 p-3 bg-white dark:bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                      <div class="flex items-center gap-2">
                        <input
                          type="radio"
                          name="category"
                          value="{{ $categorie->id }}"
                          {{ request('category') == $categorie->id ? 'checked' : '' }}
                          class="accent-[#E8192C]"
                        >
                        <span class="text-gray-800 dark:text-gray-200 font-medium">
                          {{ $categorie->category_name }}
                        </span>
                      </div>
                      <small class="text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-600 px-2 py-0.5 rounded-full text-xs">
                        {{ $categorie->active_product_count }}
                      </small>
                    </label>
                  </li>
                @endif
              @endforeach
            </ul>
          </div>

          <div class="flex flex-col gap-2">
            <button type="submit" class="w-full px-4 py-2 bg-[#E8192C] text-white rounded-lg hover:bg-red-700 transition-colors">
              Appliquer
            </button>
            <a href="{{ route('store') }}" class="w-full text-center px-4 py-2 text-sm font-medium text-[#E8192C] hover:text-red-700 border border-[#E8192C] hover:border-red-700 rounded transition-colors">
              Réinitialiser
            </a>
          </div>
        </form>
      </div>

      <!-- Produits -->
      <div class="lg:col-span-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ $totalProducts }} produit(s) trouvé(s)
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          @foreach ($products as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 border border-gray-200 dark:border-gray-700">
              <div class="aspect-square bg-gray-100 dark:bg-gray-700 rounded-lg mb-4 overflow-hidden">
                @if($product->cover)
                  <img
                    src="{{ asset('storage/product_cover/' . $product->cover) }}"
                    alt="{{ $product->product_name }}"
                    class="w-full h-full object-cover"
                  />
                @else
                  <div class="w-full h-full flex items-center justify-center text-gray-500">
                    Pas d'image
                  </div>
                @endif
              </div>

              <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-1">
                {{ $product->product_name }}
              </h3>

              <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                {{ $product->product_description ?? 'Aucune description.' }}
              </p>

              <div class="flex gap-2">
                <a
                  href="{{ route('product.detail', $product->id) }}"
                  class="flex-1 px-3 py-2 text-sm font-medium text-center bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg transition-colors"
                >
                  Voir
                </a>
                <a
                  href="{{ route('commande.produit', $product->id) }}"
                  class="flex-1 px-3 py-2 text-sm font-medium text-center bg-[#E8192C] hover:bg-red-700 text-white rounded-lg transition-colors"
                >
                  Commander
                </a>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination Laravel native -->
        <div class="mt-8">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  @endif
</div>

<style>
html.dark { color-scheme: dark; }
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

@endsection
