@extends('client_layout.master')

@section('titre')
Produit
@endsection

@section('contenu')

<div class="max-w-7xl mx-auto px-4 py-8 mt-20">
  <h1 class="text-3xl font-bold text-[#E8192C] mb-8">
    Nos Produits
  </h1>

  @php
    // Vérifie s'il y a au moins un produit actif dans toutes les catégories
    $hasAnyActiveProduct = $categories->isNotEmpty() && $categories->some(fn($cat) => $cat->products->where('status', 1)->isNotEmpty());
  @endphp

  @if (!$categories->isNotEmpty() || !$hasAnyActiveProduct)
    <!-- Aucune donnée à afficher -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-12 text-center">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-8m-8 0H4" />
      </svg>
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
        Aucun produit disponible
      </h3>
      <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
        Il n’y a actuellement aucun produit enregistré dans notre catalogue.
        Revenez plus tard ou contactez-nous pour plus d’informations.
      </p>
    </div>
  @else
    <!-- Affichage normal avec filtres et produits -->
    @php
      $totalActiveProducts = $categories->sum(fn($cat) => $cat->products->where('status', 1)->count());
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Colonne gauche : Filtres -->
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

        <!-- Bouton réinitialiser -->
        <div>
          <button id="resetFilters" type="button"
            class="w-full mt-2 px-4 py-2 text-sm font-medium text-[#E8192C] hover:text-red-700 border border-[#E8192C] hover:border-red-700 rounded transition-colors">
            Réinitialiser les filtres
          </button>
        </div>

        <!-- Catégories -->
        <div class="bg-gray-100 dark:bg-gray-900 p-5 rounded-xl shadow-md mb-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#E8192C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
            </svg>
            Catégories
          </h2>

          <ul id="categoryFilters" class="space-y-3">
            @foreach ($categories as $categorie)
              @php
                $activeCount = $categorie->products->where('status', 1)->count();
              @endphp
              @if ($activeCount > 0)
                <li>
                  <label class="flex items-center justify-between gap-3 p-3 bg-white dark:bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                    <div class="flex items-center gap-2">
                      <input
                        type="checkbox"
                        class="category-checkbox accent-[#E8192C]"
                        value="{{ $categorie->id }}"
                      >
                      <span class="text-gray-800 dark:text-gray-200 font-medium">
                        {{ $categorie->category_name }}
                      </span>
                    </div>
                    <small class="text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-600 px-2 py-0.5 rounded-full text-xs">
                      {{ $activeCount }}
                    </small>
                  </label>
                </li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>

      <!-- Colonne droite : Produits -->
      <div class="lg:col-span-3">
        <!-- Barre de tri + compteur -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ $totalActiveProducts }} produits trouvés
          </p>
        </div>

        <!-- Grille de produits -->
        <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          @foreach ($categories as $categorie)
            @php
              $activeProducts = $categorie->products->where('status', 1);
            @endphp
            @if ($activeProducts->isNotEmpty())
              @foreach ($activeProducts as $product)
                <div
                  class="product-card bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-4 border border-gray-200 dark:border-gray-700"
                  data-category="{{ $categorie->id }}"
                  data-name="{{ strtolower($product->product_name) }}"
                >
                  <!-- Image -->
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

                  <!-- Nom -->
                  <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-1">
                    {{ $product->product_name }}
                  </h3>

                  <!-- Description -->
                  <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                    {{ $product->product_description ?? 'Aucune description.' }}
                  </p>

                  <!-- Boutons -->
                  <div class="flex gap-2">
                    <a
                      href="{{ url('/productdetail/' . $product->id) }}"
                      class="flex-1 px-3 py-2 text-sm font-medium text-center bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg transition-colors"
                    >
                      Voir
                    </a>
                    <a
                      href="{{ url('/commandeproduit/' . $product->id) }}"
                      class="flex-1 px-3 py-2 text-sm font-medium text-center bg-[#E8192C] hover:bg-red-700 text-white rounded-lg transition-colors"
                    >
                      Commander
                    </a>
                  </div>
                </div>
              @endforeach
            @endif
          @endforeach
        </div>

        <!-- Aucun produit trouvé après filtrage -->
        <div id="noResults" class="text-center py-12 hidden">
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467-.884-6.124-2.364M18 12a6 6 0 11-12 0 6 6 0 0112 0z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Aucun produit trouvé</h3>
          <p class="text-gray-500 dark:text-gray-400">Essayez de réinitialiser vos filtres.</p>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="mt-8 flex justify-center space-x-1"></div>
      </div>
    </div>
  @endif
</div>

@endsection

<style>
html.dark {
  color-scheme: dark;
}
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Ne pas exécuter la logique JS si aucun produit n'est affiché
  @if (!$categories->isNotEmpty() || !$hasAnyActiveProduct)
    return;
  @endif

  const searchInput = document.getElementById('search');
  const resetBtn = document.getElementById('resetFilters');
  const checkboxes = document.querySelectorAll('.category-checkbox');
  const noResults = document.getElementById('noResults');
  const paginationEl = document.getElementById('pagination');

  const allProductCards = Array.from(document.querySelectorAll('.product-card'));
  const productsPerPage = 6;
  let currentPage = 1;
  let filteredProducts = [...allProductCards];

  function debounce(fn, wait = 250) {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn.apply(this, args), wait);
    };
  }

  function applyFiltersAndPagination() {
    const query = (searchInput.value || '').trim().toLowerCase();
    const selectedCategories = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    filteredProducts = allProductCards.filter(card => {
      const name = (card.dataset.name || '').toLowerCase();
      const category = String(card.dataset.category || '');
      const matchesSearch = !query || name.includes(query);
      const matchesCategory = selectedCategories.length === 0 || selectedCategories.includes(category);
      return matchesSearch && matchesCategory;
    });

    currentPage = 1;
    renderPage();
    renderPagination();
  }

  function renderPage() {
    const start = (currentPage - 1) * productsPerPage;
    const end = start + productsPerPage;
    const pageProducts = filteredProducts.slice(start, end);

    allProductCards.forEach(card => card.classList.add('hidden'));

    if (pageProducts.length === 0) {
      noResults.classList.remove('hidden');
    } else {
      noResults.classList.add('hidden');
      pageProducts.forEach(card => card.classList.remove('hidden'));
    }
  }

  function renderPagination() {
    const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
    paginationEl.innerHTML = '';

    if (totalPages <= 1) return;

    if (currentPage > 1) {
      const prevBtn = document.createElement('button');
      prevBtn.textContent = '«';
      prevBtn.className = 'px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors';
      prevBtn.addEventListener('click', () => {
        currentPage--;
        renderPage();
        renderPagination();
      });
      paginationEl.appendChild(prevBtn);
    }

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);

    for (let i = startPage; i <= endPage; i++) {
      const pageBtn = document.createElement('button');
      pageBtn.textContent = i;
      pageBtn.className = `px-3 py-1 rounded-lg transition-colors ${
        i === currentPage
          ? 'bg-[#E8192C] text-white'
          : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'
      }`;
      pageBtn.addEventListener('click', () => {
        currentPage = i;
        renderPage();
        renderPagination();
      });
      paginationEl.appendChild(pageBtn);
    }

    if (currentPage < totalPages) {
      const nextBtn = document.createElement('button');
      nextBtn.textContent = '»';
      nextBtn.className = 'px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors';
      nextBtn.addEventListener('click', () => {
        currentPage++;
        renderPage();
        renderPagination();
      });
      paginationEl.appendChild(nextBtn);
    }
  }

  const debouncedApply = debounce(applyFiltersAndPagination, 200);
  searchInput.addEventListener('input', debouncedApply);
  checkboxes.forEach(cb => cb.addEventListener('change', applyFiltersAndPagination));

  resetBtn.addEventListener('click', () => {
    checkboxes.forEach(cb => cb.checked = false);
    searchInput.value = '';
    applyFiltersAndPagination();
  });

  applyFiltersAndPagination();
});
</script>
@endpush
