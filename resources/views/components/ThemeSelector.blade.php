{{-- resources/views/components/theme-toggle.blade.php --}}
<button
    id="theme-toggle"
    type="button"
    class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors outline-none focus:ring-2 focus:ring-[#E8192C]"
    aria-label="Basculer le thème"
>
    <!-- Soleil (thème clair) -->
    <svg id="sun-icon" class="hidden w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
    </svg>

    <!-- Lune (thème sombre) -->
    <svg id="moon-icon" class="hidden w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
    </svg>
</button>

<script>
(function() {
    const html = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    const toggleBtn = document.getElementById('theme-toggle');

    // Récupère le thème sauvegardé ou utilise 'dark' par défaut
    const savedTheme = localStorage.getItem('theme') || 'dark';

    // Applique le thème au chargement
    if (savedTheme === 'light') {
        html.classList.remove('dark');
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
    } else {
        html.classList.add('dark');
        moonIcon.classList.remove('hidden');
        sunIcon.classList.add('hidden');
    }

    // Toggle au clic
    toggleBtn.addEventListener('click', () => {
        const isDark = html.classList.contains('dark');

        if (isDark) {
            // Passer en clair
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        } else {
            // Passer en sombre
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            moonIcon.classList.remove('hidden');
            sunIcon.classList.add('hidden');
        }
    });
})();
</script>
