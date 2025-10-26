@extends('admin_layout.master')

@section('titre')
    rainbow_contact
@endsection

@section('contenu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contact</h1>
            <p>

            </p>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Accueil</a></li>
              <li class="breadcrumb-item active">Contact</li>
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
                <h3 class="card-title">Tous les messages</h3>
              </div>

              
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Num.</th>
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Téléphone</th>
                      <th>Message</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($contacts as $contact)
                      <tr id="contact-row-{{ $contact->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone ?? '—' }}</td>
                        <td>
                          @if ($contact->message)
                            <span title="{{ $contact->message }}">
                              {{ Str::limit($contact->message, 50) }}
                            </span>
                          @else
                            <em>Aucun message</em>
                          @endif
                        </td>
                        <td class="text-center">
                          <!-- Voir le détail -->
                          <a href="{{ url('/admin/detailcontact/' . $contact->id) }}" class="btn btn-info btn-sm" title="Voir le détail">
                            <i class="fas fa-eye"></i>
                          </a>

                          <!-- Supprimer (AJAX + SweetAlert) -->
                          <button type="button"
                                  class="btn btn-danger btn-sm delete-contact"
                                  data-contact-id="{{ $contact->id }}"
                                  title="Supprimer">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center">Aucun message de contact reçu.</td>
                      </tr>
                    @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Num.</th>
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Téléphone</th>
                      <th>Message</th>
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

      // Gestion de la suppression avec SweetAlert2
      $(document).on('click', '.delete-contact', function () {
        const contactId = $(this).data('contact-id');
        const row = $(`#contact-row-${contactId}`);

        Swal.fire({
          title: 'Êtes-vous sûr ?',
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
              url: `/admin/deletecontact/${contactId}`,
              type: 'POST',
              data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
              },
              success: function (response) {
                Swal.fire({
                  icon: 'success',
                  title: 'Supprimé !',
                  text: response.success || 'Le message a été supprimé.',
                  timer: 1500,
                  showConfirmButton: false
                });
                row.fadeOut(400, function() { $(this).remove(); });
              },
              error: function (xhr) {
                Swal.fire({
                  icon: 'error',
                  title: 'Erreur',
                  text: xhr.responseJSON?.message || 'Une erreur est survenue lors de la suppression.',
                });
              }
            });
          }
        });
      });
    });
  </script>
@endsection
