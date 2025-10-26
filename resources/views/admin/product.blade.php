@extends('admin_layout.master')

@section('titre')
   Rainbow-business produits
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
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
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
                        <tr>
                          <td>{{ $counter++ }}</td>
                          <td>
                            <img src="{{ $product->cover ? asset('storage/product_cover/' . $product->cover) : asset('backend/dist/img/default-product.png') }}"
                                 style="height: 50px; width: 50px; object-fit: cover;"
                                 class="img-circle elevation-2"
                                 alt="{{ $product->product_name }}">
                          </td>
                          <td>{{ $product->product_name }}</td>
                          <td>{{ Str::limit($product->product_description, 50) }}</td>
                          <td>{{ $categorie->category_name ?? $product->product_category }}</td>
                          <td>{{ number_format($product->product_price, 0, ',', ' ') }} F</td>
                          <td>{{ $product->product_promo ? number_format($product->product_promo, 0, ',', ' ') . ' F' : '—' }}</td>
                          <td>{{ $product->product_reduction ? $product->product_reduction . ' %' : '—' }}</td>
                          <td>{{ $product->product_brand === 'Nouveau' ? 'Nouveau' : '—' }}</td>
                          <td>
                            @if ($product->status == 1)
                              <span class="badge bg-success status-badge">Activé</span>
                            @else
                              <span class="badge bg-warning status-badge">Désactivé</span>
                            @endif
                          </td>
                        <td class="text-center">
                                {{-- Voir le détail --}}
                                <a href="{{ route('admin.detailproduit', $product->id) }}"
                                class="btn btn-info btn-sm" title="Voir le détail">
                                    <i class="fas fa-info-circle"></i>
                                </a>

                                {{-- Activer/Désactiver --}}
                                <button
                                    class="btn btn-sm toggle-status-btn"
                                    data-product-id="{{ $product->id }}"
                                    data-current-status="{{ $product->status }}"
                                    title="{{ $product->status == 1 ? 'Désactiver' : 'Activer' }}"
                                >
                                    @if ($product->status == 1)
                                        <i class="fas fa-eye text-primary"></i>
                                    @else
                                        <i class="fas fa-eye-slash text-warning"></i>
                                    @endif
                                </button>

                                {{-- Modifier --}}
                                <a href="{{ route('admin.editeproduct', $product->id) }}"
                                class="btn btn-primary btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- 🔥 Supprimer avec SweetAlert2 --}}
                                <button type="button"
                                        class="btn btn-danger btn-sm delete-product"
                                        data-product-id="{{ $product->id }}"
                                        title="Supprimer ce produit">
                                    <i class="fas fa-trash"></i>
                                </button>
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
  <!-- DataTables JS -->
  <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        }
      });

      // 🔁 Toggle status (inchangé)
      $('.toggle-status-btn').on('click', function () {
        const button = $(this);
        const productId = button.data('product-id');
        const currentStatus = button.data('current-status');
        const newStatus = currentStatus === 1 ? 0 : 1;
        const url = newStatus === 1
          ? `/admin/activateproduct/${productId}`
          : `/admin/unactivateproduct/${productId}`;

        button.prop('disabled', true);

        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
          },
          success: function () {
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
          error: function () {
            alert('Erreur lors du changement de statut.');
          },
          complete: function () {
            button.prop('disabled', false);
          }
        });
      });

      // 💥 Suppression produit avec SweetAlert2
      $(document).on('click', '.delete-product', function () {
        const productId = $(this).data('product-id');
        const row = $(`tr[data-product-id="${productId}"]`);

        Swal.fire({
          title: 'Êtes-vous sûr ?',
          html: "La suppression supprimera <b>toutes les images</b> associées à ce produit.<br>Vous ne pourrez pas revenir en arrière !",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Oui, supprimer !',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/admin/yesdeleteproduct/${productId}`,
              type: 'POST',
              data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
              },
              success: function (response) {
                Swal.fire({
                  icon: 'success',
                  title: 'Supprimé !',
                  text: 'Le produit a été supprimé avec succès.',
                  timer: 1500,
                  showConfirmButton: false
                });
                row.fadeOut(400, function() { $(this).remove(); });
              },
              error: function (xhr) {
                Swal.fire({
                  icon: 'error',
                  title: 'Erreur',
                  text: xhr.responseJSON?.message || 'Une erreur est survenue.',
                });
              }
            });
          }
        });
      });
    });
  </script>
@endsection

