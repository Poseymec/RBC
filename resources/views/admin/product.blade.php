@extends('admin_layout.master')

@section('titre')
    NLelectro produits
@endsection

@section('contenu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Produits</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Accueil</a></li>
              <li class="breadcrumb-item active">Produits</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tous les Produits</h3>
              </div>

              @if (session('status'))
                <div class="alert alert-success m-3">{{ session('status') }}</div>
              @endif

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Num</th>
                      <th>Image</th>
                      <th>Nom</th>
                      <th>Description</th>
                      <th>Catégorie</th>
                      <th>Prix</th>
                      <th>Promo</th>
                      <th>%</th>
                      <th>Marque</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $counter = 1; @endphp

                    @foreach ($categories as $categorie)
                      @foreach ($categorie->products as $product)
                        <tr data-product-id="{{ $product->id }}">
                          <td>{{ $counter++ }}</td>
                          <td>
                            <img src="{{ asset('storage/product_cover/' . $product->cover) }}"
                                 style="height: 50px; width: 50px;"
                                 class="img-circle elevation-2"
                                 alt="{{ $product->product_name }}">
                          </td>
                          <td>{{ $product->product_name }}</td>
                          <td>{{ Str::limit($product->product_description, 50) }}</td>
                          <td>{{ $categorie->category_name ?? $product->product_category }}</td>
                          <td>{{ number_format($product->product_price, 0, ',', ' ') }} F</td>
                          <td>{{ $product->product_promo ? 'Oui' : 'Non' }}</td>
                          <td>{{ $product->product_reduction }} %</td>
                          <td>{{ $product->product_brand ?? '—' }}</td>
                          <td>
                            @if ($product->status == 1)
                              <span class="badge bg-success status-badge">Activé</span>
                            @else
                              <span class="badge bg-warning status-badge">Désactivé</span>
                            @endif
                          </td>
                          <td class="text-center">
                            {{-- Voir le détail --}}
                            <a href="{{ url('/admin/detailproduit/' . $product->id) }}"
                               class="btn btn-info btn-sm" title="Voir le détail">
                              <i class="fas fa-info-circle"></i>
                            </a>

                            {{-- 🔁 Bouton Activer/Désactiver (AJAX) --}}
                            <button
                              class="btn btn-sm toggle-status-btn"
                              data-product-id="{{ $product->id }}"
                              data-current-status="{{ $product->status }}"
                              title="{{ $product->status == 1 ? 'Désactiver' : 'Activer' }}"
                            >
                              @if ($product->status == 1)
                                <i class="nav-icon fas fa-eye text-primary"></i>
                              @else
                                <i class="nav-icon fas fa-eye-slash text-warning"></i>
                              @endif
                            </button>

                            {{-- Modifier --}}
                            <a href="{{ url('/admin/editeproduct/' . $product->id) }}"
                               class="btn btn-primary btn-sm" title="Modifier">
                              <i class="fas fa-edit"></i>
                            </a>

                            {{-- Supprimer --}}
                            <form action="{{ url('/admin/deleteproduct/' . $product->id) }}"
                                  method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                              @csrf
                              @method('DELETE')
                            </form>
                           <a href="{{url('/admin/deleteproduct/'.$product->id)}}" id="delete" class="btn btn-danger"  style="display:inline-block;"><i class="nav-icon fas fa-trash"></i></a>
                          </td>
                        </tr>
                      @endforeach
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Num</th>
                      <th>Image</th>
                      <th>Nom</th>
                      <th>Description</th>
                      <th>Catégorie</th>
                      <th>Prix</th>
                      <th>Promo</th>
                      <th>%</th>
                      <th>Marque</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('script')
  <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        }
      });

      // 🔁 Gestion du changement de statut via AJAX
      $('.toggle-status-btn').on('click', function () {
        const button = $(this);
        const productId = button.data('product-id');
        const currentStatus = button.data('current-status');
        const newStatus = currentStatus === 1 ? 0 : 1;
        const url = newStatus === 1
          ? `/admin/activateproduct/${productId}`
          : `/admin/unactivateproduct/${productId}`;

        // Désactiver le bouton pendant la requête
        button.prop('disabled', true).addClass('disabled');

        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
          },
          success: function (response) {
            // Mettre à jour l’affichage
            const badge = button.closest('tr').find('.status-badge');
            const icon = button.find('i');

            if (newStatus === 1) {
              badge.removeClass('bg-warning').addClass('bg-success').text('Activé');
              icon.removeClass('fa-eye-slash text-warning').addClass('fa-eye text-primary');
              button.attr('title', 'Désactiver');
            } else {
              badge.removeClass('bg-success').addClass('bg-warning').text('Désactivé');
              icon.removeClass('fa-eye text-primary').addClass('fa-eye-slash text-warning');
              button.attr('title', 'Activer');
            }

            button.data('current-status', newStatus);
          },
          error: function (xhr) {
            alert('Erreur lors du changement de statut. Veuillez réessayer.');
            console.error(xhr);
          },
          complete: function () {
            button.prop('disabled', false).removeClass('disabled');
          }
        });
      });
    });
  </script>
@endsection
