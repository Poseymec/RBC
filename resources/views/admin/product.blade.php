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
                    @php
                      $counter = 1;
                    @endphp

                    @foreach ($categories as $categorie)
                      @foreach ($categorie->products as $product)
                        <tr>
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
                              <span class="badge bg-success">Activé</span>
                            @else
                              <span class="badge bg-warning">Désactivé</span>
                            @endif
                          </td>
                          <td class="text-center">
                            <!-- 👁️ Voir le détail -->
                            <a href="{{ url('/admin/detailproduit/' . $product->id) }}" class="btn btn-info btn-sm" title="Voir le détail">
                              <i class="fas fa-eye"></i>
                            </a>

                            <!-- 👁️/👁️‍🗨️ Activer / Désactiver -->
                            @if ($product->status == 1)
                              <form action="{{ url('/admin/unactivateproduct/' . $product->id) }}" method="POST" style="display:inline;" title="Désactiver">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary btn-sm">
                                  <i class="fas fa-eye"></i>
                                </button>
                              </form>
                            @else
                              <form action="{{ url('/admin/activateproduct/' . $product->id) }}" method="POST" style="display:inline;" title="Activer">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning btn-sm">
                                  <i class="fas fa-eye-slash"></i>
                                </button>
                              </form>
                            @endif

                            <!-- ✏️ Modifier -->
                            <a href="{{ url('/admin/editeproduct/' . $product->id) }}" class="btn btn-primary btn-sm" title="Modifier">
                              <i class="fas fa-edit"></i>
                            </a>

                            <!-- 🗑️ Supprimer -->
                            <form action="{{ url('/admin/deleteproduct/' . $product->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
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
    });
  </script>
@endsection
