@extends('admin_layout.master')
@section('titre')
   Rainbow-business slider
@endsection

@section('contenu')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Sliders</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Sliders</li>
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
              <h3 class="card-title">Tous les Sliders</h3>
              <a href="{{ route('admin.addslider') }}" class="btn btn-success float-right">Ajouter un Slider</a>
            </div>

            @if (Session::has('status'))
              <div class="alert alert-success m-3">{{ Session::get('status') }}</div>
            @endif

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Num.</th>
                    <th>Image</th>
                    <th>Description 1</th>
                    <th>Description 2</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($sliders as $index => $slider)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>
                        <img src="{{ asset('storage/slider_images/' . $slider->image) }}"
                             style="height: 50px; width: 50px; object-fit: cover;"
                             class="img-circle elevation-2"
                             alt="Slider">
                      </td>
                      <td>{{ Str::limit($slider->description1, 30) }}</td>
                      <td>{{ Str::limit($slider->description2, 30) }}</td>
                      <td style="text-align: center">
                        <!-- Activer / Désactiver -->
                        @if ($slider->status == 1)
                          <form action="{{ route('admin.unactivateslider', $slider->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary btn-sm" title="Désactiver">
                              <i class="fas fa-eye"></i>
                            </button>
                          </form>
                        @else
                          <form action="{{ route('admin.activateslider', $slider->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning btn-sm" title="Activer">
                              <i class="fas fa-eye-slash"></i>
                            </button>
                          </form>
                        @endif

                        <!-- Modifier -->
                        <a href="{{ route('admin.editeslider', $slider->id) }}" class="btn btn-primary btn-sm" title="Modifier">
                          <i class="fas fa-edit"></i>
                        </a>

                        <!-- 🔥 Supprimer avec SweetAlert2 (JavaScript pur) -->
                        <button type="button"
                                class="btn btn-danger btn-sm delete-slider"
                                data-id="{{ $slider->id }}"
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
                    <th>Image</th>
                    <th>Description 1</th>
                    <th>Description 2</th>
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
<!-- DataTables -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script de suppression en JavaScript pur -->
<script>
  // Initialisation de DataTables
  document.addEventListener('DOMContentLoaded', function () {
    $('#example1').DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
      }
    });

    // 🔥 Gestionnaire de suppression (JavaScript pur)
    document.querySelectorAll('.delete-slider').forEach(button => {
      button.addEventListener('click', function () {
        const sliderId = this.getAttribute('data-id');
        const row = this.closest('tr');

        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "Ce slider sera supprimé définitivement !",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Oui, supprimer !',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`/admin/destroy/${sliderId}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Supprimé !',
                  text: data.success,
                  timer: 1500,
                  showConfirmButton: false
                });
                row.style.transition = 'opacity 0.4s';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 400);
              } else {
                throw new Error(data.error || 'Erreur inconnue');
              }
            })
            .catch(error => {
              Swal.fire({
                icon: 'error',
                title: 'Échec',
                text: 'Une erreur est survenue lors de la suppression.'
              });
              console.error('Erreur:', error);
            });
          }
        });
      });
    });
  });
</script>
@endsection
