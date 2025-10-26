@extends('admin_layout.master')

@section('titre')
    rainbow_newsletter
@endsection

@section('contenu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Newsletter</h1>
            <p>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Accueil</a></li>
              <li class="breadcrumb-item active">Newsletter</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tous les contacts de la newsletter</h3>
              </div>

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Num.</th>
                      <th>Email</th>
                      <th>Téléphone</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($letters as $letter)
                      <tr id="newsletter-row-{{ $letter->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $letter->email }}</td>
                        <td>{{ $letter->phone ?? '—' }}</td>
                        <td class="text-center">
                          <button type="button"
                                  class="btn btn-danger btn-sm delete-newsletter"
                                  data-id="{{ $letter->id }}"
                                  title="Supprimer">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center">Aucun abonné à la newsletter.</td>
                      </tr>
                    @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Num.</th>
                      <th>Email</th>
                      <th>Téléphone</th>
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

      // Suppression avec SweetAlert2
      $(document).on('click', '.delete-newsletter', function () {
        const id = $(this).data('id');
        const row = $(`#newsletter-row-${id}`);

        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "Cet abonné sera supprimé définitivement.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Oui, supprimer !',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/admin/newsletter/${id}`,
              type: 'POST',
              data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
              },
              success: function (response) {
                Swal.fire({
                  icon: 'success',
                  title: 'Supprimé !',
                  text: response.success || 'Abonné supprimé avec succès.',
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
