<body class="bg-white dark:bg-[#111827] text-gray-900 dark:text-gray-100 ">

  <!-- Navbar -->
  <nav class="bg-white/50 backdrop-blur border-b border-gray-200/40 dark:bg-gray-900/50 dark:border-gray-700/40 fixed top-4 left-4 right-4 z-50 rounded-2xl shadow-md shadow-black/25 dark:shadow-black/70 transition-all duration-300">
    <div class="max-w-screen-xl mx-auto px-3 py-2 flex items-center justify-between">
      <!-- Logo -->
      <a href="/" class="flex items-center space-x-2 rtl:space-x-reverse z-10">
        <img src="{{ asset('logo/logo7.png') }}" class="h-10" alt="Logo" />
      </a>

      <!-- Menu desktop -->
      <div class="hidden md:flex md:items-center md:space-x-4 font-medium">
        <a href="/#home" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-bold text-red-600 dark:text-red-400 nav-link" data-section="home">Accueil</a>
        <a href="/#about" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 nav-link" data-section="about">À propos</a>
        <a href="/#services" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 nav-link" data-section="services">Services</a>
        <a href="/#contact" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 nav-link" data-section="contact">Contact</a>
        <a href="/store" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 produit-link">Produit</a>
      </div>

      <!-- Contrôles : Theme + Auth + Burger -->
      <div class="flex items-center gap-2 z-10">
        <!-- Theme Toggle -->
        <button id="themeToggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
          <i class="ti ti-sun dark:hidden w-5 h-5"></i>
          <i class="ti ti-moon hidden dark:block w-5 h-5"></i>
        </button>

        <!-- Menu d'authentification (desktop) -->
        <div class="hidden md:flex items-center gap-2">
          @guest
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400">
                Inscription
              </a>
            @endif
            @if (Route::has('login'))
              <a href="{{ route('login') }}" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400">
                Connexion
              </a>
            @endif
          @else
            <!-- Dropdown utilisateur connecté -->
            <div class="relative group">
              <button class="font-sans flex items-center gap-1 py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 md:hover:bg-transparent md:hover:text-red-600 md:dark:hover:text-red-400 focus:outline-none">
                <i class="ti ti-user-circle text-lg"></i>
                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
              </button>

              <!-- Menu déroulant -->
              <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50 hidden group-hover:block dark:border dark:border-gray-700">
                @role('super-Admin|Admin')
                  <a href="{{ url('/admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 flex items-center gap-2">
                    <i class="ti ti-shield-lock"></i> Administration
                  </a>
                  <hr class="my-1 border-gray-200 dark:border-gray-700">
                @endrole

                <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2">
                  @csrf
                  <button type="submit" class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 flex items-center gap-2">
                    <i class="ti ti-logout"></i> Déconnexion
                  </button>
                </form>
              </div>
            </div>
          @endguest
        </div>

        <!-- Bouton burger (mobile) -->
        <button id="mobileMenuButton" type="button" class="inline-flex items-center p-2 w-8 h-8 justify-center text-red-400 rounded-lg md:hidden hover:bg-red-100/70 focus:outline-none focus:ring-2 focus:ring-red-300/50 dark:text-red-300 dark:hover:bg-red-700/70 dark:focus:ring-red-600/50 transition-colors duration-200">
          <span class="sr-only">Menu</span>
          <i class="ti ti-menu-2 w-5 h-5"></i>
        </button>
      </div>
    </div>

    <!-- Menu mobile -->
    <div id="mobileMenu" class="hidden md:hidden mt-2 pb-3 px-3 space-y-2 bg-white/50 backdrop-blur dark:bg-gray-900/50 rounded-b-2xl">
      <a href="/#home" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-bold text-red-600 dark:text-red-400 nav-link-mobile" data-section="home">Accueil</a>
      <a href="/#about" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 nav-link-mobile" data-section="about">À propos</a>
      <a href="/#services" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 nav-link-mobile" data-section="services">Services</a>
      <a href="/#contact" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 nav-link-mobile" data-section="contact">Contact</a>
      <a href="/store" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70 produit-link-mobile">Produit</a>

      <!-- Authentification mobile -->
      <div class="pt-3 border-t border-gray-200/40 dark:border-gray-700/40">
        @guest
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70">
              Inscription
            </a>
          @endif
          @if (Route::has('login'))
            <a href="{{ route('login') }}" class="font-sans block py-2 px-3 rounded-lg transition-colors duration-200 text-center text-lg font-medium text-gray-900 hover:bg-gray-100/70 dark:text-gray-200 dark:hover:bg-gray-700/70">
              Connexion
            </a>
          @endif
        @else
          <div class="px-3 py-2">
            <div class="text-center font-medium text-gray-900 dark:text-gray-200 mb-2">
              Bonjour, {{ Auth::user()->name }}
            </div>

            @role('super-Admin|Admin')
              <a href="{{ url('/admin') }}" class="block w-full text-center py-2 px-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white mb-2">
                Administration
              </a>
            @endrole

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-center py-2 px-3 rounded-lg bg-red-100 hover:bg-red-200 dark:bg-red-900/50 dark:hover:bg-red-800 text-red-700 dark:text-red-300 font-medium">
                Déconnexion
              </button>
            </form>
          </div>
        @endguest
      </div>
    </div>
  </nav>

  <script>
    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    themeToggle?.addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
    });

    document.addEventListener('DOMContentLoaded', () => {
      const mobileMenuButton = document.getElementById('mobileMenuButton');
      const mobileMenu = document.getElementById('mobileMenu');
      const navLinksDesktop = document.querySelectorAll('.nav-link');
      const navLinksMobile = document.querySelectorAll('.nav-link-mobile');
      const produitLinkDesktop = document.querySelector('.produit-link');
      const produitLinkMobile = document.querySelector('.produit-link-mobile');
      const allNavLinks = [...navLinksDesktop, ...navLinksMobile];

      // Toggle menu mobile
      if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', () => {
          mobileMenu?.classList.toggle('hidden');
        });
      }

      // Fermer menu mobile au clic sur un lien
      allNavLinks.forEach(link => {
        link.addEventListener('click', () => {
          mobileMenu?.classList.add('hidden');
        });
      });

      // Fonction pour activer un lien
      const activateLink = (link) => {
        link.classList.add('text-red-600', 'dark:text-red-400', 'font-bold');
        link.classList.remove('text-gray-900', 'dark:text-gray-200', 'font-medium');
      };

      // Fonction pour désactiver un lien
      const deactivateLink = (link) => {
        link.classList.remove('text-red-600', 'dark:text-red-400', 'font-bold');
        link.classList.add('text-gray-900', 'dark:text-gray-200', 'font-medium');
      };

      // --- Gestion selon la page ---
      const currentPath = window.location.pathname;

      if (['/', '/fr', '/en'].includes(currentPath)) {
        // PAGE D'ACCUEIL
        if (produitLinkDesktop) deactivateLink(produitLinkDesktop);
        if (produitLinkMobile) deactivateLink(produitLinkMobile);

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

          navLinksDesktop.forEach(link => {
            if (link.dataset.section === currentSection) activateLink(link);
            else deactivateLink(link);
          });
          navLinksMobile.forEach(link => {
            if (link.dataset.section === currentSection) activateLink(link);
            else deactivateLink(link);
          });
        };

        allNavLinks.forEach(link => {
          link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.includes('#')) {
              const targetId = href.split('#')[1];
              const target = document.getElementById(targetId);
              if (target) {
                e.preventDefault();
                window.scrollTo({ top: target.offsetTop - 100, behavior: 'smooth' });
              }
            }
          });
        });

        window.addEventListener('scroll', updateActiveLink);
        updateActiveLink();

      } else if (currentPath.includes('/store')) {
        // PAGE PRODUIT
        navLinksDesktop.forEach(link => deactivateLink(link));
        navLinksMobile.forEach(link => deactivateLink(link));
        if (produitLinkDesktop) activateLink(produitLinkDesktop);
        if (produitLinkMobile) activateLink(produitLinkMobile);

      } else {
        // AUTRES PAGES
        navLinksDesktop.forEach(link => deactivateLink(link));
        navLinksMobile.forEach(link => deactivateLink(link));
        if (produitLinkDesktop) deactivateLink(produitLinkDesktop);
        if (produitLinkMobile) deactivateLink(produitLinkMobile);
      }
    });
  </script>

