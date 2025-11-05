<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>rainbow-business</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  	<link rel="stylesheet" type="text/css" href="{{asset('Frontend/css/roboto-font.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('Frontend/css/fontawesome-all.min.css')}}">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="{{asset('Frontend/css/style.css')}}"/>
  <script>
    // Active le mode sombre par défaut comme dans ton composant
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
  <style>




    footer a {
      transition: all 0.2s ease;
    }
    footer a:hover {
      color: #f87171 !important; /* rouge doux */
    }
  </style>
</head>



        {{---debut header et navbar--}}

            @include('client_layout.header')

        {{---fin header et navbar--}}


                {{-- debut du contenu---}}

                @yield('contenu')

                {{-- fin du contenu---}}

          {{---debut footer--}}

          @include('client_layout.footer')

          {{---fin fooer--}}




</html>
