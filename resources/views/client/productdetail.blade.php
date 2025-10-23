@extends('client_layout.master')

@section('titre')
    {{ $product->product_name }}
@endsection

@section('contenu')
<section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <!-- 🔙 Bouton retour -->
        <div class="mb-6">
            <a
                href="{{ url('/store') }}"
                class="inline-flex items-center gap-2 text-[#E8192C] hover:text-red-700 font-medium transition-colors group"
            >
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux produits
            </a>
        </div>

        <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <!-- Galerie d'images -->
            <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                @php
                    // Récupère toutes les images : cover + product_images
                    $images = [];
                    if ($product->cover) {
                        $images[] = ['type' => 'cover', 'path' => $product->cover];
                    }
                    foreach ($product->product_images as $img) {
                        $images[] = ['type' => 'gallery', 'path' => $img->images];
                    }
                    // Si aucune image, on en met une par défaut
                    if (empty($images)) {
                        $images[] = ['type' => 'placeholder', 'path' => null];
                    }
                    $firstImage = $images[0]['path'] ?? null;
                @endphp

                <!-- Image principale -->
                <div class="mb-4 aspect-square bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden flex items-center justify-center">
                    @if($firstImage)
                        <img
                            id="mainProductImage"
                            src="{{ asset('storage/products_images/' . $firstImage) }}"
                            alt="{{ $product->product_name }}"
                            class="w-full h-full object-contain"
                        />
                    @else
                        <span class="text-gray-500">Aucune image</span>
                    @endif
                </div>

                <!-- Miniatures (carrousel horizontal) -->
                @if(count($images) > 1)
                    <div class="flex gap-2 overflow-x-auto pb-2 hide-scrollbar">
                        @foreach($images as $img)
                            @if($img['path'])
                                <button
                                    type="button"
                                    class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-[#E8192C] transition"
                                    onclick="document.getElementById('mainProductImage').src='{{ asset('storage/products_images/' . $img['path']) }}'"
                                >
                                    <img
                                        src="{{ asset('storage/products_images/' . $img['path']) }}"
                                        alt="Miniature"
                                        class="w-full h-full object-cover"
                                    />
                                </button>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Détails -->
            <div class="mt-6 sm:mt-8 lg:mt-0">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    {{ $product->product_name }}
                </h1>

                <!-- Catégorie -->
                <div class="mt-2">
                    @if($product->category)
                        <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                            {{ $product->category->category_name }}
                        </span>
                    @else
                        <span class="inline-block px-3 py-1 text-xs font-medium bg-gray-200 text-gray-600 rounded-full">
                            Catégorie non définie
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed break-words">
                        {{ $product->product_description ?? 'Aucune description disponible.' }}
                    </p>
                </div>

                <!-- Bouton Commander -->
                <div class="mt-6">
                    <a
                        href="{{url('/commandeproduit/'.$product->id)}}"
                        class="px-6 py-3 bg-[#E8192C] hover:bg-red-700 text-white font-medium rounded-lg shadow-md transition-colors inline-block"
                    >
                        Commander ce produit
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
.break-words {
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}
/* Masquer la barre de défilement tout en permettant le scroll */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;  /* IE et Edge */
    scrollbar-width: none;     /* Firefox */
}
</style>
