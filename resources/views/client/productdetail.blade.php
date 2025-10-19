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
                <svg
                    class="w-5 h-5 group-hover:-translate-x-1 transition-transform"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
                Retour aux produits
            </a>
        </div>

        <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <!-- Image -->
            <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                <img
                    src="{{ asset('storage/product_cover/' . $product->cover) }}"
                    alt="{{ $product->product_name }}"
                    class="w-full rounded-lg shadow-md"
                />
            </div>

            <!-- Détails -->
            <div class="mt-6 sm:mt-8 lg:mt-0">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    {{ $product->product_name }}
                </h1>

                <!-- Prix & Étoiles -->
                <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                    <p class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">
                        {{ number_format($product->product_promo, 0, ',', ' ') }} FCFA
                    </p>

                    <div class="flex items-center gap-2 mt-2 sm:mt-0">
                        <div class="flex items-center gap-1">
                            @php
                                $fullStars = floor($product->rating);
                                $halfStar = $product->rating - $fullStars >= 0.5;
                            @endphp
                            @for ($i = 0; $i < $fullStars; $i++)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.872 1.44 8.296L12 18.896l-7.376 4.578 1.44-8.296-6.064-5.872 8.332-1.151z"/>
                                </svg>
                            @endfor
                            @if ($halfStar)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0l3.668 7.568 8.332 1.151-6.064 5.872 1.44 8.296L12 18.896V0z"/>
                                </svg>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            ({{ $product->rating }})
                        </p>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $product->reviews_count }} avis
                        </span>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                    <button
                        type="button"
                        class="flex items-center justify-center py-2.5 px-5 text-sm font-medium rounded-lg border bg-white text-gray-900 border-gray-200 hover:bg-gray-100 hover:text-red-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700"
                    >
                        <svg
                            class="w-5 h-5 -ms-2 me-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"
                            />
                        </svg>
                        Ajouter aux favoris
                    </button>
                </div>

                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                <!-- Description -->
                <div class="space-y-3">
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
