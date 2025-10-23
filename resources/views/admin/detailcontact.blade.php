@extends('admin_layout.master')

@section('titre')
    Détail - Contact
@endsection

@section('contenu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Détail du message</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Accueil</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/contact') }}">Contact</a></li>
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
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Message de <strong>{{ $contact->name ?? 'Anonyme' }}</strong></h3>
                <div class="card-tools">
                  <a href="{{ url('/admin/contact') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                  </a>
                </div>
              </div>

              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-sm-3"><strong>Email :</strong></div>
                  <div class="col-sm-9">
                    @if($contact->email)
                      <a href="mailto:{{ $contact->email }}" class="text-primary">{{ $contact->email }}</a>
                    @else
                      —
                    @endif
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-3"><strong>Téléphone :</strong></div>
                  <div class="col-sm-9">
                    @if($contact->phone)
                      <a href="tel:{{ $contact->phone }}" class="text-primary">{{ $contact->phone }}</a>
                    @else
                      —
                    @endif
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-3"><strong>Date :</strong></div>
                  <div class="col-sm-9">
                    {{ $contact->created_at ? $contact->created_at->format('d/m/Y \à H:i') : '—' }}
                  </div>
                </div>

                <hr>

                <div class="row">
                  <div class="col-12">
                    <h5><i class="fas fa-envelope text-info"></i> Message :</h5>
                    <div class="mt-2 p-3 bg-light rounded" style="font-size: 1.05rem; line-height: 1.6; white-space: pre-wrap; min-height: 80px;">
                      {{ $contact->message ?? 'Aucun message fourni.' }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-footer text-right">
                <form action="{{ url('/admin/deletecontact/' . $contact->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Supprimer ce message
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
