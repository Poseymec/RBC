
@extends('client_layout.master')
@section('titre')
    produit

@endsection

@section('contenu')

  <div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-[#E8192C] mb-8">
      Nos Produits
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Colonne Gauche : Filtres (statiques) -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Recherche -->
        <div>
          <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Rechercher
          </label>
          <input
            id="search"
            type="text"
            placeholder="Nom du produit..."
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:border-transparent"
          />
        </div>

        <!-- Catégories -->
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Catégorie
          </label>
          <select
            id="category"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:border-transparent"
          >
            <option value="">Toutes les catégories</option>
            <option value="imprimantes">Imprimantes</option>
            <option value="scanners">Scanners</option>
            <option value="consommables">Consommables</option>
            <option value="papier" selected>Papier</option>
            <option value="logiciels">Logiciels</option>
          </select>
        </div>

        <!-- Prix -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Prix (FCFA)
          </h3>
          <div class="space-y-4">
            <input
              type="number"
              min="0"
              max="5000"
              value="0"
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm"
              placeholder="Min"
            />
            <input
              type="number"
              min="0"
              max="10000"
              value="5000"
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm"
              placeholder="Max"
            />
          </div>
        </div>

        <!-- Bouton Réinitialiser -->
        <button
          type="button"
          class="w-full py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
        >
          Réinitialiser les filtres
        </button>
      </div>

      <!-- Colonne Droite : Produits -->
      <div class="lg:col-span-3">
        <!-- Barre de tri -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
          <p class="text-sm text-gray-600 dark:text-gray-400">
            6 produits trouvés
          </p>
          <div class="flex items-center gap-2">
            <label for="sort" class="text-sm font-medium text-gray-700 dark:text-gray-300">
              Trier par :
            </label>
            <select
              id="sort"
              class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-[#E8192C]"
            >
              <option value="popular" selected>Populaire</option>
              <option value="price-asc">Prix croissant</option>
              <option value="price-desc">Prix décroissant</option>
              <option value="rating">Meilleure note</option>
              <option value="reviews">Plus de commentaires</option>
            </select>
          </div>
        </div>

        <!-- Grille de produits -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Produit 1 -->
          <div class="bg-gray-200 dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-md transition-shadow p-4">
            <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 overflow-hidden">
              <img src="/images/image3.jpg" alt="Papier aluminium premium" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
              Papier aluminium premium
            </h3>
            <div class="flex items-center justify-between">
              <span class="text-lg font-bold text-[#E8192C]">
                1 500 FCFA
              </span>
              <a href="/product/1" class="px-3 py-1 text-sm bg-[#E8192C] hover:bg-red-700 text-white rounded transition-colors">
                Voir
              </a>
            </div>
          </div>

          <!-- Produit 2 -->
          <div class="bg-gray-200 dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-md transition-shadow p-4">
            <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 overflow-hidden">
              <img src="/images/image2.jpg" alt="Papier aluminium économique" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
              Papier aluminium économique
            </h3>
            <div class="flex items-center justify-between">
              <span class="text-lg font-bold text-[#E8192C]">
                3 000 FCFA
              </span>
              <a href="/product/2" class="px-3 py-1 text-sm bg-[#E8192C] hover:bg-red-700 text-white rounded transition-colors">
                Voir
              </a>
            </div>
          </div>

          <!-- Produit 3 -->
          <div class="bg-gray-200 dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-md transition-shadow p-4">
            <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 overflow-hidden">
              <img src="/images/image3.jpg" alt="Papier aluminium industriel" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
              Papier aluminium industriel
            </h3>
            <div class="flex items-center justify-between">
              <span class="text-lg font-bold text-[#E8192C]">
                1 000 FCFA
              </span>
              <a href="/product/3" class="px-3 py-1 text-sm bg-[#E8192C] hover:bg-red-700 text-white rounded transition-colors">
                Voir
              </a>
            </div>
          </div>

          <!-- Produit 4 -->
          <div class="bg-gray-200 dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-md transition-shadow p-4">
            <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 overflow-hidden">
              <img src="/images/image4.jpg" alt="Papier aluminium alimentaire" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
              Papier aluminium alimentaire
            </h3>
            <div class="flex items-center justify-between">
              <span class="text-lg font-bold text-[#E8192C]">
                500 FCFA
              </span>
              <a href="/product/4" class="px-3 py-1 text-sm bg-[#E8192C] hover:bg-red-700 text-white rounded transition-colors">
                Voir
              </a>
            </div>
          </div>

          <!-- Produit 5 -->
          <div class="bg-gray-200 dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-md transition-shadow p-4">
            <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 overflow-hidden">
              <img src="/images/image1.jpg" alt="Papier aluminium recyclé" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
              Papier aluminium recyclé
            </h3>
            <div class="flex items-center justify-between">
              <span class="text-lg font-bold text-[#E8192C]">
                500 FCFA
              </span>
              <a href="/product/5" class="px-3 py-1 text-sm bg-[#E8192C] hover:bg-red-700 text-white rounded transition-colors">
                Voir
              </a>
            </div>
          </div>

          <!-- Produit 6 -->
          <div class="bg-gray-200 dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-md transition-shadow p-4">
            <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 overflow-hidden">
              <img src="/images/image4.jpg" alt="Papier aluminium extra-large" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
              Papier aluminium extra-large
            </h3>
            <div class="flex items-center justify-between">
              <span class="text-lg font-bold text-[#E8192C]">
                1 500 FCFA
              </span>
              <a href="/product/6" class="px-3 py-1 text-sm bg-[#E8192C] hover:bg-red-700 text-white rounded transition-colors">
                Voir
              </a>
            </div>
          </div>
        </div>

        <!-- ❌ Section "Aucun résultat" : commentée car on a des produits -->
        <!--
        <div class="text-center py-12">
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467-.884-6.124-2.364M18 12a6 6 0 11-12 0 6 6 0 0112 0z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">
            Aucun produit trouvé
          </h3>
          <p class="text-gray-500 dark:text-gray-400">
            Essayez de réinitialiser vos filtres.
          </p>
          <button type="button" class="mt-4 px-4 py-2 text-sm font-medium text-[#E8192C] hover:text-red-700 border border-[#E8192C] hover:border-red-700 rounded transition-colors">
            Réinitialiser les filtres
          </button>
        </div>
        -->
      </div>
    </div>
  </div>
@endsection


  <style>
    html.dark {
      color-scheme: dark;
    }
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>
