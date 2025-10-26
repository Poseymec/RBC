@extends('admin_layout.master')

@section('titre')
    Détail - Produit
@endsection

@section('contenu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Détail du produit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Accueil</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/product') }}">Produits</a></li>
              <li class="breadcrumb-item active">Détail</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">{{ $product->product_name }}</h3>
                <div class="card-tools">
                  <a href="{{ url('/admin/product') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                  </a>
                </div>
              </div>

              <div class="card-body">
                <!-- Image principale -->
                <div class="text-center mb-4">
                  @if($product->cover)
                    <img src="{{ asset('storage/product_cover/' . $product->cover) }}"
                         alt="{{ $product->product_name }}"
                         class="img-fluid img-thumbnail rounded"
                         style="max-height: 300px; object-fit: contain;">
                  @else
                    <div class="text-muted py-4">Aucune image de couverture</div>
                  @endif
                </div>

                <!-- Tableau des informations techniques -->
                <table class="table table-bordered mb-4">
                  <tbody>
                    <tr>
                      <th style="width: 30%">Nom</th>
                      <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                      <th>Catégorie</th>
                      <td>{{ $product->category ? $product->category->category_name : '—' }}</td>
                    </tr>
                    <tr>
                      <th>Prix</th>
                      <td>{{ number_format($product->product_price, 0, ',', ' ') }} F</td>
                    </tr>
                    <tr>
                      <th>Promo</th>
                      <td>
                        @if($product->product_promo)
                          <span class="badge bg-success">Oui ({{ $product->product_reduction }} %)</span>
                        @else
                          <span class="badge bg-secondary">Non</span>
                        @endif
                      </td>
                    </tr>
                    @if($product->product_promo)
                    <tr>
                      <th>Prix après réduction</th>
                      <td>{{ number_format($product->product_price * (1 - $product->product_reduction / 100), 0, ',', ' ') }} F</td>
                    </tr>
                    @endif
                    <tr>
                      <th>Marque</th>
                      <td>{{ $product->product_brand ?? '—' }}</td>
                    </tr>
                    <tr>
                      <th>Status</th>
                      <td>
                        @if($product->status == 1)
                          <span class="badge bg-success">Activé</span>
                        @else
                          <span class="badge bg-warning">Désactivé</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <th>Date d’ajout</th>
                      <td>{{ $product->created_at ? $product->created_at->format('d/m/Y \à H:i') : '—' }}</td>
                    </tr>
                  </tbody>
                </table>

                <!-- Description complète (largeur pleine) -->
                <div class="mb-4">
                  <h5 class="font-weight-bold mb-2">Description :</h5>
                  <div class="p-3 bg-light rounded" style="white-space: pre-wrap; word-break: break-word; min-height: 60px;">
                    {{ $product->product_description ?? 'Aucune description disponible.' }}
                  </div>
                </div>

                <!-- Galerie d'images supplémentaires (si elles existent) -->
                @if($product->product_images && $product->product_images->isNotEmpty())
                  <div class="mb-4">
                    <h5 class="font-weight-bold mb-2">Images supplémentaires :</h5>
                    <div class="d-flex flex-wrap gap-2">
                      @foreach($product->product_images as $image)
                        <a href="{{ asset('storage/products_images/' . $image->images) }}" target="_blank">
                          <img src="{{ asset('storage/products_images/' . $image->images) }}"
                               alt="Image {{ $loop->index + 1 }}"
                               class="img-thumbnail"
                               style="width: 80px; height: 80px; object-fit: cover;">
                        </a>
                      @endforeach
                    </div>
                  </div>
                @endif
              </div>

              <div class="card-footer text-right">
                <a href="{{ url('/admin/editeproduct/' . $product->id) }}" class="btn btn-primary">
                  <i class="fas fa-edit"></i> Modifier
                </a>

                <form action="{{ url('/admin/deleteproduct/' . $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Supprimer
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
