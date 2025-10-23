<script>
  // Active le mode sombre
  tailwind.config = { darkMode: 'class' }
</script>

<body class="mb-10 bg-white dark:bg-[#111827] text-gray-900 dark:text-gray-100">
  <!-- Navbar -->
  <nav class="mb-10 bg-white/50 backdrop-blur border-b border-gray-200/40 dark:bg-gray-900/50 dark:border-gray-700/40 fixed top-4 left-4 right-4 z-50 rounded-2xl shadow-md shadow-black/25 dark:shadow-black/70 transition-all duration-300">
    <div class="max-w-screen-xl mx-auto px-3 py-2 flex items-center justify-between">
      <!-- Logo -->
      <a href="/" class="flex items-center space-x-2 rtl:space-x-reverse z-10">
        <img src="{{ asset('logo/logo7.png') }}" class="h-10" alt="Logo" />
      </a>

      <!-- Menu desktop -->
      <div class="hidden md:flex md:items-center md:space-x-4 font-medium">
        <a href="{{ url('/') }}#home" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-bold text-red-600 dark:text-red-400 nav-link" data-section="home">Accueil</a>
<a href="{{ url('/') }}#about" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 nav-link" data-section="about">À propos</a>
<a href="{{ url('/') }}#services" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 nav-link" data-section="services">Services</a>
<a href="{{ url('/') }}#contact" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 nav-link" data-section="contact">Contact</a>
        <a href="{{ url('/store') }}" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400">Produit</a>
      </div>

      <!-- Contrôles -->
      <div class="flex items-center gap-2 z-10">
        <x-locale-switcher />
        <x-ThemeSelector />
        <!-- Bouton burger -->
        <button id="mobileMenuButton" type="button" class="inline-flex items-center p-2 w-8 h-8 justify-center text-red-400 rounded-lg md:hidden hover:bg-red-100/70 focus:outline-none focus:ring-2 focus:ring-red-300/50 dark:text-red-300 dark:hover:bg-red-700/70 dark:focus:ring-red-600/50 transition-colors duration-200">
          <span class="sr-only">Menu</span>
          <i class="ti ti-menu-2 w-5 h-5"></i>
        </button>
      </div>
    </div>

    <!-- Menu mobile (caché par défaut) -->
    <div id="mobileMenu" class="hidden md:hidden mt-2 pb-3 px-3 space-y-2 bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-b-2xl shadow-lg">
      <a href="#home" class="block py-2 px-3 rounded-lg text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 nav-link">Accueil</a>
      <a href="#about" class="block py-2 px-3 rounded-lg text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 nav-link">À propos</a>
      <a href="#services" class="block py-2 px-3 rounded-lg text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 nav-link">Services</a>
      <a href="#contact" class="block py-2 px-3 rounded-lg text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 nav-link">Contact</a>
      <a href="{{ url('/store') }}" class="block py-2 px-3 rounded-lg text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70">Produit</a>
    </div>
  </nav>

  <!-- Contenu de la page -->
  @yield('contenu')

  <!-- Script de navigation fluide + menu mobile -->
 <script>
  document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const navLinks = document.querySelectorAll('.nav-link');

    // Toggle menu mobile
    if (mobileMenuButton) {
      mobileMenuButton.addEventListener('click', () => {
        mobileMenu?.classList.toggle('hidden');
      });
    }

    // Fermer menu mobile au clic
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu?.classList.add('hidden');
      });
    });

    // --- Gestion du scroll fluide + classe active (SEULEMENT sur la home) ---
    if (['/', '/fr', '/en'].includes(window.location.pathname)) {
      // Mettre à jour le lien actif au scroll
      const updateActiveLink = () => {
        let currentSection = '';
        const sections = ['home', 'about', 'services', 'contact'];

        for (const section of sections) {
          const element = document.getElementById(section);
          if (element) {
            const rect = element.getBoundingClientRect();
            if (rect.top <= 150 && rect.bottom >= 150) {
              currentSection = section;
              break;
            }
          }
        }

        navLinks.forEach(link => {
          if (link.dataset.section === currentSection) {
            link.classList.add('text-red-600', 'dark:text-red-400', 'font-bold');
            link.classList.remove('text-gray-900', 'dark:text-gray-200', 'font-medium');
          } else {
            link.classList.remove('text-red-600', 'dark:text-red-400', 'font-bold');
            link.classList.add('text-gray-900', 'dark:text-gray-200');
            // Garde font-medium sauf pour Accueil
            if (link.dataset.section !== 'home') {
              link.classList.add('font-medium');
            }
          }
        });
      };

      // Scroll fluide au clic
      navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          const targetId = this.getAttribute('href').split('#')[1];
          const target = document.getElementById(targetId);

          if (target) {
            e.preventDefault();
            window.scrollTo({
              top: target.offsetTop - 100,
              behavior: 'smooth'
            });
          }
        });
      });

      // Observer le scroll
      window.addEventListener('scroll', updateActiveLink);
      updateActiveLink(); // au chargement
    }
  });
</script>
</body>
