<div class="min-h-screen bg-gray-50 dark:bg-gray-900 mt-10 rounded-3xl shadow-xl transition-colors duration-300">
  <div class="max-w-6xl mx-auto px-4 py-12 sm:py-16 md:py-24">
    <div class="backdrop-blur-lg bg-white/60 dark:bg-gray-900/60 rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-200 dark:border-gray-700">
      <!-- Titre principal -->
      <div class="text-center lg:text-left mb-10 lg:mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-[#E8192C]">
          Contactez-nous
        </h1>
        <p class="mt-3 text-gray-700 dark:text-gray-300">
          Une question ? Une demande particulière ? Nous sommes là pour vous répondre.
        </p>
      </div>

      <!-- Grille responsive -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
        <!-- 📩 Newsletter -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
          <div class="flex items-center gap-3 mb-5">
            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6m-2 0V6h4M5 21V3h1v16a1 1 0 0 0 1 1H5z"/>
              </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
              Newsletter
            </h2>
          </div>
          <p class="mb-6 text-gray-700 dark:text-gray-300">
            Restez informé de nos nouveautés, promotions et événements exclusifs.
          </p>

          <!-- ✅ Formulaire newsletter avec @csrf -->
          <form id="newsletter-form" class="space-y-5">
            @csrf
            <div>
              <label for="newsletter-email" class="block mb-2 font-medium text-[#E8192C] dark:text-red-400">
                Adresse e-mail *
              </label>
              <input
                id="newsletter-email"
                name="email"
                type="email"
                required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:outline-none"
                placeholder="votre@email.com"
              />
            </div>
            <div>
              <label for="newsletter-phone" class="block mb-2 font-medium text-[#E8192C] dark:text-red-400">
                Téléphone (optionnel)
              </label>
              <input
                id="newsletter-phone"
                name="phone"
                type="tel"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:outline-none"
                placeholder="+237 6XX XXX XXX"
              />
            </div>
            <button
              type="submit"
              class="w-full py-3 font-bold text-white bg-[#E8192C] rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#E8192C]"
            >
              S’abonner
            </button>
            <!-- Zone de feedback -->
            <div id="newsletter-feedback" class="mt-2 text-sm"></div>
          </form>
        </div>

        <!-- ✉️ Contact -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
          <div class="flex items-center gap-3 mb-5">
            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2m-4.12 9.88l-6.5 4.5c-.37.25-.86.25-1.23 0L4 15.5V6l8 5.5l8-5.5v9.38z"/>
              </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
              Formulaire de contact
            </h2>
          </div>
          <p class="mb-6 text-gray-700 dark:text-gray-300">
            Envoyez-nous un message directement. Nous vous répondrons dans les plus brefs délais.
          </p>

          <!-- ✅ Formulaire contact avec @csrf -->
          <form id="contact-form" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="name" class="block mb-2 font-medium text-[#E8192C] dark:text-red-400">
                  Nom complet *
                </label>
                <input
                  id="name"
                  name="name"
                  type="text"
                  required
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:outline-none"
                  placeholder="Rainbow Business"
                />
              </div>
              <div>
                <label for="email" class="block mb-2 font-medium text-[#E8192C] dark:text-red-400">
                  Adresse e-mail *
                </label>
                <input
                  id="email"
                  name="email"
                  type="email"
                  required
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:outline-none"
                  placeholder="votre@email.com"
                />
              </div>
            </div>
            <div>
              <label for="phone" class="block mb-2 font-medium text-[#E8192C] dark:text-red-400">
                Téléphone (optionnel)
              </label>
              <input
                id="phone"
                name="phone"
                type="tel"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:outline-none"
                placeholder="+237 6XX XXX XXX"
              />
            </div>
            <div>
              <label for="message" class="block mb-2 font-medium text-[#E8192C] dark:text-red-400">
                Message *
              </label>
              <textarea
                id="message"
                name="message"
                rows="5"
                required
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-[#E8192C] focus:outline-none"
                placeholder="Écrivez votre message ici..."
              ></textarea>
            </div>
            <button
              type="submit"
              class="w-full py-3 font-bold text-white bg-[#E8192C] rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#E8192C]"
            >
              Envoyer le message
            </button>
            <!-- Zone de feedback -->
            <div id="contact-feedback" class="mt-2 text-sm"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  input::placeholder, textarea::placeholder {
    color: #9ca3af;
  }
  .dark input::placeholder, .dark textarea::placeholder {
    color: #6b7280;
  }
</style>

<script>
(function() {
  // --- Formulaire Newsletter ---
  const newsletterForm = document.getElementById('newsletter-form');
  const newsletterFeedback = document.getElementById('newsletter-feedback');

  if (newsletterForm) {
    newsletterForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(newsletterForm);

      try {
        const response = await fetch("{{ route('newsletter.store') }}", {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        const result = await response.json();

        if (response.ok) {
          newsletterFeedback.innerHTML = `<span class="text-green-600 dark:text-green-400">${result.success}</span>`;
          newsletterForm.reset();
        } else {
          const errors = result.errors || [result.message || 'Erreur inconnue'];
          newsletterFeedback.innerHTML = `<span class="text-red-600 dark:text-red-400">${errors.join('<br>')}</span>`;
        }
      } catch (error) {
        newsletterFeedback.innerHTML = `<span class="text-red-600 dark:text-red-400">Erreur réseau. Veuillez réessayer.</span>`;
      }
    });
  }

  // --- Formulaire Contact ---
  const contactForm = document.getElementById('contact-form');
  const contactFeedback = document.getElementById('contact-feedback');

  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(contactForm);

      try {
        const response = await fetch("{{ route('contact.store') }}", {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        const result = await response.json();

        if (response.ok) {
          contactFeedback.innerHTML = `<span class="text-green-600 dark:text-green-400">${result.success}</span>`;
          contactForm.reset();
        } else {
          const errors = result.errors || [result.message || 'Erreur inconnue'];
          contactFeedback.innerHTML = `<span class="text-red-600 dark:text-red-400">${errors.join('<br>')}</span>`;
        }
      } catch (error) {
        contactFeedback.innerHTML = `<span class="text-red-600 dark:text-red-400">Erreur réseau. Veuillez réessayer.</span>`;
      }
    });
  }
})();
</script>
