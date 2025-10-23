@extends('admin_layout.master')

@section('titre')
    Détail - Produit
@endsection

@section('contenu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
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
              <li class="breadcrumb-item"><a href="{{ url('/admin/produits') }}">Produits</a></li>
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
              <div class="card-header">
                <h3 class="card-title">{{ $product->product_name }}</h3>
                <div class="card-tools">
                  <a href="{{ url('/admin/produits') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                  </a>
                </div>
              </div>

              <div class="card-body">
                <!-- Image du produit -->
                <div class="text-center mb-4">
                  @if($product->cover)
                    <img src="{{ asset('storage/product_cover/' . $product->cover) }}"
                         alt="{{ $product->product_name }}"
                         class="img-fluid img-thumbnail"
                         style="max-height: 300px; object-fit: contain;">
                  @else
                    <div class="text-muted">Aucune image</div>
                  @endif
                </div>

                <!-- Informations détaillées -->
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 35%">Nom du produit</th>
                    <td>{{ $product->product_name }}</td>
                  </tr>
                  <tr>
                    <th>Description</th>
                    <td style="white-space: pre-wrap;">{{ $product->product_description ?? '—' }}</td>
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
                    <th>En promotion ?</th>
                    <td>{{ $product->product_promo ? 'Oui' : 'Non' }}</td>
                  </tr>
                  @if($product->product_promo)
                    <tr>
                      <th>Réduction</th>
                      <td>{{ $product->product_reduction }} %</td>
                    </tr>
                    <tr>
                      <th>Prix après réduction</th>
                      <td>
                        {{ number_format($product->product_price * (1 - $product->product_reduction / 100), 0, ',', ' ') }} F
                      </td>
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
                </table>
              </div>

              <div class="card-footer text-right">
                <!-- Modifier -->
                <a href="{{ url('/admin/editeproduct/' . $product->id) }}" class="btn btn-primary">
                  <i class="fas fa-edit"></i> Modifier
                </a>

                <!-- Supprimer -->
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
