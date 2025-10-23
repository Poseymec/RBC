

@extends('client_layout.master')
@section('titre')

	accuil_Rainbow_Business

@endsection

@section('contenu')
  <main class="pt-5 mt-10 pb-20 px-4 md:px-8">
    <!-- Section Héro -->
    <section id="home" class="max-w-4xl mx-auto text-center mb-24">
      <div class="bg-transparent backdrop-blur-sm rounded-2xl px-6 py-12">
        <!-- Logo avec animation flottante -->
        <div class="mb-4 floating-div">
          <img
           src="{{asset('logo/logo7.png')}}"
            alt="Logo Rainbow Business"
            class="mx-auto h-32 md:h-40 lg:h-48"
          />
        </div>

        <!-- Titre -->
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#E8192C] mb-6 lg:text-6xl">
          Bienvenue chez Rainbow Business
        </h1>

        <!-- Description -->
        <p class="text-base md:text-xl text-gray-800 dark:text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
          Découvrez nos produits de qualité et notre engagement envers l’excellence.
        </p>

        <!-- Bouton CTA -->
        <a
          href="/product"
          class="cta-button inline-block px-6 py-3 bg-[#E8192C] text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300"
        >
          Voir nos produits
        </a>
      </div>
    </section>

    <!-- Carousel (version statique) -->
    <section class="max-w-6xl mx-auto mb-24">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-8 text-center">
        Nos Produits Phares
    </h2>

    <div id="sliderContainer" class="relative overflow-hidden rounded-2xl shadow-2xl">
        <!-- Slides -->
        <div class="flex transition-transform duration-500" id="slidesWrapper">
        @foreach ($sliders as $slider)
        <div class="min-w-full relative">
            <img
            src="{{ asset('storage/slider_images/' . $slider->image) }}"
            alt="{{ $slider->image }}"
            class="w-full h-64 md:h-64 object-cover"
            />
            <div class="absolute inset-0 bg-black/30 flex flex-col justify-center items-start p-6 md:p-12">
            <h5 class="text-white text-lg md:text-xl font-semibold mb-2">{{ $slider->description1 }}</h5>
            <p class="text-white mb-4">{{ $slider->description2 }}</p>

            </div>
        </div>
        @endforeach
        </div>

        <!-- Indicateurs -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @foreach ($sliders as $index => $slider)
        <span class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" data-slide="{{ $index }}"></span>
        @endforeach
        </div>

        <!-- Flèches -->
        <button id="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/30 text-white rounded-full flex items-center justify-center backdrop-blur-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        </button>
        <button id="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/30 text-white rounded-full flex items-center justify-center backdrop-blur-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        </button>
    </div>
    </section>
    <section id="about">
         @include('client.about')
    </section>
    <section id="services">
            @include('client.services')
    </section>
        <section id="contact">
            @include('client.contact')
    </section>
  </main>
@endsection
  <style>
    /* Animation flottante du logo */
    .floating-div {
      animation: float 2s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    /* Hover sur les boutons (flèches, indicateurs) */
    button:hover {
      transform: scale(1.05);
    }

    /* Style du CTA */
    .cta-button {
      transition: all 0.3s ease;
    }
    .cta-button:hover {
      box-shadow: 0 10px 25px -5px rgba(232, 25, 44, 0.4);
      transform: translateY(-2px);
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
  const slidesWrapper = document.getElementById('slidesWrapper');
  const slides = slidesWrapper.children;
  const indicators = document.querySelectorAll('#sliderContainer [data-slide]');
  const prevBtn = document.getElementById('prevSlide');
  const nextBtn = document.getElementById('nextSlide');
  let current = 0;

  function updateSlider() {
    slidesWrapper.style.transform = `translateX(-${current * 100}%)`;
    indicators.forEach((ind, i) => {
      ind.classList.toggle('bg-white', i === current);
      ind.classList.toggle('bg-white/50', i !== current);
    });
  }

  prevBtn.addEventListener('click', () => {
    current = (current === 0) ? slides.length - 1 : current - 1;
    updateSlider();
  });

  nextBtn.addEventListener('click', () => {
    current = (current + 1) % slides.length;
    updateSlider();
  });

  indicators.forEach(ind => {
    ind.addEventListener('click', () => {
      current = parseInt(ind.dataset.slide);
      updateSlider();
    });
  });

  // Optionnel : auto slide
  setInterval(() => {
    current = (current + 1) % slides.length;
    updateSlider();
  }, 5000);
});
  </script>
