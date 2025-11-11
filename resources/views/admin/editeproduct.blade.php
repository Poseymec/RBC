@extends('admin_layout.master')
@section('titre')
    Modifier Produit -Rainbow-business
@endsection

@section('contenu')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Modifier Produit</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Modifier Produit</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Formulaire de modification</h3>
            </div>

            @if (Session::has('status'))
              <div class="alert alert-success m-3">{{ Session::get('status') }}</div>
            @endif

            <form action="{{ route('admin.updateproduct', $product->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label>Nom du produit</label>
                  <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
                </div>

                <div class="form-group">
                  <label>Prix du produit</label>
                  <input type="number" name="product_price" class="form-control" value="{{ old('product_price', $product->product_price) }}" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                  <label>Prix promo</label>
                  <input type="number" name="product_promo" class="form-control" value="{{ old('product_promo', $product->product_promo) }}" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                  <label>Pourcentage de réduction (facultatif)</label>
                  <input type="number" name="product_reduction" class="form-control" value="{{ old('product_reduction', $product->product_reduction) }}" min="0" max="100">
                </div>

                <div class="form-group">
                  <label>
                    <input type="checkbox" name="product_brand" value="1" {{ (old('product_brand', $product->product_brand) === 'Nouveau') ? 'checked' : '' }}>
                    Marquer comme "Nouveau"
                  </label>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <textarea name="product_description" class="form-control" rows="5" required>{{ old('product_description', $product->product_description) }}</textarea>
                </div>

                <div class="form-group">
                  <label>Catégorie</label>
                  <select class="form-control" name="product_category" required>
                    <option value="">Choisir une catégorie</option>
                    @foreach ($categories as $category)
                      <option value="{{ $category->category_name }}" {{ (old('product_category', $product->product_category) == $category->category_name) ? 'selected' : '' }}>
                        {{ $category->category_name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <!-- Image de couverture actuelle -->
                @if($product->cover)
                  <div class="form-group">
                    <label>Image de couverture actuelle</label><br>
                    <img src="{{ asset('storage/product_cover/' . $product->cover) }}" style="height:100px; object-fit: cover;" alt="Cover">
                  </div>
                @endif

                <div class="form-group">
                  <label>Nouvelle image de couverture (facultatif)</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="cover" class="custom-file-input" id="cover">
                      <label class="custom-file-label">Choisir un fichier</label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Ajouter d'autres images (facultatif)</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="images[]" class="custom-file-input" id="images" multiple>
                      <label class="custom-file-label">Choisir des fichiers</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Liste des images existantes -->
        <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Images du produit</h3>
            </div>
            <div class="card-body">
              @if($product->product_images->count() > 0)
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($product->product_images as $index => $image)
                      <tr id="image-row-{{ $image->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td style="text-align: center;">
                          <img src="{{ asset('storage/products_images/' . $image->images) }}"
                               style="height: 50px; width: 50px; object-fit: cover;"
                               class="img-circle elevation-2"
                               alt="Image">
                        </td>
                        <td style="text-align: center;">
                          <button type="button"
                                  class="btn btn-danger btn-sm delete-image"
                                  data-image-id="{{ $image->id }}">
                            <i class="fas fa-trash"></i> Supprimer
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <p class="text-muted">Aucune image associée à ce produit.</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

{{-- ✅ Script de suppression fiable --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Affichage du nom du fichier sélectionné
  document.querySelectorAll('.custom-file-input').forEach(input => {
    input.addEventListener('change', function(e) {
      let fileName = e.target.files.length > 1
        ? `${e.target.files.length} fichiers sélectionnés`
        : e.target.files[0]?.name || 'Choisir un fichier';
      e.target.nextElementSibling.textContent = fileName;
    });
  });

  // 🔥 Gestion de la suppression avec SweetAlert2 (sans jQuery)
  document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-image')) {
      const button = e.target.closest('.delete-image');
      const imageId = button.dataset.imageId;
      const row = document.getElementById(`image-row-${imageId}`);

      Swal.fire({
        title: 'Supprimer cette image ?',
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
      }).then((result) => {
        if (result.isConfirmed) {
          // Créer un formulaire dynamique
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '/admin/destroyProductImage/' + imageId;

          const csrf = document.createElement('input');
          csrf.type = 'hidden';
          csrf.name = '_token';
          csrf.value = '{{ csrf_token() }}';

          const method = document.createElement('input');
          method.type = 'hidden';
          method.name = '_method';
          method.value = 'DELETE';

          form.appendChild(csrf);
          form.appendChild(method);
          document.body.appendChild(form);
          form.submit();
        }
      });
    }
  });
</script>
@endsection
