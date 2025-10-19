

  <script>
    // Active le mode sombre par défaut comme dans ton composant
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
  <body class=" bg-white dark:bg-[#111827] text-gray-900 dark:text-gray-100">
  <!-- Navbar exactement comme dans ton template -->
  <nav class=" mb-10  bg-white/50 backdrop-blur border-b border-gray-200/40 dark:bg-gray-900/50 dark:border-gray-700/40 fixed top-4 left-4 right-4 z-50 rounded-2xl shadow-md shadow-black/25 dark:shadow-black/70 transition-all duration-300">
    <div class="max-w-screen-xl mx-auto px-3 py-2 flex items-center justify-between">

      <!-- Logo -->
      <a href="/" class="flex items-center space-x-2 rtl:space-x-reverse z-10">
        <img src="{{asset('logo/logo7.png')}}"  class="h-10" alt="Logo" />
      </a>

      <!-- Menu (mobile caché par défaut, desktop visible) -->
      <!-- Ici, on le rend visible uniquement sur desktop pour le rendu statique -->
      <div class="hidden md:flex md:items-center md:space-x-4 font-medium">
        <!-- Items de navigation -->
        <a href="/" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-bold text-red-600 dark:text-red-400">
          Accueil
        </a>
        <a href="/#about" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400">
          À propos
        </a>
        <a href="/#services" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400">
          Services
        </a>
        <a href="/#contact" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400">
          Contact
        </a>
        <a href="{{url('/store')}} "class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400">
          Produit
        </a>
      </div>

      <!-- Contrôles : Langue, Thème, Bouton mobile -->
      <div class="flex items-center gap-2 z-10">
        <!-- Simuler LocaleSelector -->
        <x-locale-switcher />
        <!-- Simuler ThemeSelector -->
       <x-ThemeSelector/>

        <!-- Bouton menu mobile (burger) -->
        <button type="button" class="inline-flex items-center p-2 w-8 h-8 justify-center text-red-400 rounded-lg md:hidden hover:bg-red-100/70 focus:outline-none focus:ring-2 focus:ring-red-300/50 dark:text-red-300 dark:hover:bg-red-700/70 dark:focus:ring-red-600/50 transition-colors duration-200">
          <span class="sr-only">Menu</span>
          <i class="ti ti-menu-2 w-5 h-5"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Contenu factice pour le scroll -->
  <!--<div class="space-y-96 px-4">
    <section id="hero" class="h-96 bg-blue-100 dark:bg-blue-900/30 rounded-xl"></section>
    <section id="about" class="h-96 bg-green-100 dark:bg-green-900/30 rounded-xl"></section>
    <section id="services" class="h-96 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl"></section>
    <section id="contact" class="h-96 bg-purple-100 dark:bg-purple-900/30 rounded-xl"></section>
  </div>-->

