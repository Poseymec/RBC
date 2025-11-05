@extends('admin_layout.master')
@section('titre')
   Rainbow-business_categories
@endsection

@section('contenu')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Catégories</h1>
          <p>
            @auth
              {{ auth()->user()->name }}
              {{ auth()->user()->getRoleNames() }}
              {{ auth()->user()->getPermissionNames() }}
            @endauth
          </p>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Catégories</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Toutes les Catégories</h3>
            </div>

            @if (Session::has('status'))
              <div class="alert alert-success m-3">{{ Session::get('status') }}</div>
            @endif

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Num.</th>
                    <th>Nom de la catégorie</th>
                    <th>Quantité de produits</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($categories as $index => $category)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $category->category_name }}</td>
                      <td>{{ $category->products_count }}</td>
                      <td style="text-align: center">
                        <a href="{{ route('admin.editecategory', $category->id) }}" class="btn btn-primary btn-sm" title="Modifier">
                          <i class="fas fa-edit"></i>
                        </a>

                        <button type="button"
                                class="btn btn-danger btn-sm delete-category"
                                data-category-id="{{ $category->id }}"
                                title="Supprimer">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Num.</th>
                    <th>Nom de la catégorie</th>
                    <th>Quantité de produits</th>
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

    // 🔥 Suppression avec SweetAlert2
    $(document).on('click', '.delete-category', function () {
      const categoryId = $(this).data('category-id');
      const row = $(this).closest('tr');

      Swal.fire({
        title: 'Supprimer cette catégorie ?',
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `/admin/yesdeletecategory/${categoryId}`,
            type: 'DELETE',
            data: {
              _token: '{{ csrf_token() }}'
            },
            success: function (response) {
              Swal.fire({
                icon: 'success',
                title: 'Supprimé !',
                text: response.success,
                timer: 1500,
                showConfirmButton: false
              });
              row.fadeOut(400, function() { $(this).remove(); });
            },
            error: function (xhr) {
              let message = 'Une erreur est survenue.';
              if (xhr.responseJSON?.error) {
                message = xhr.responseJSON.error;
              }
              Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: message,
              });
            }
          });
        }
      });
    });
  });
</script>
@endsection
