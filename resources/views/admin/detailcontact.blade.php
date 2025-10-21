@extends('admin_layout.master')
@section('titre')

    rainbow_contact

@endsection
@section('contenu')
<div class="max-w-4xl mx-auto p-4">
    <div class="flex items-center gap-4 mb-6">
        <a
            href="{{ url()->previous() }}"
            class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
            title="Retour à la liste"
        >
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-red-600">Détail du message</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <!-- En-tête -->
        <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                <span class="font-medium text-gray-900 dark:text-white">{{ $contact->name }}</span>
                •
                <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:underline">{{ $contact->email }}</a>
                @if($contact->phone)
                    • {{ $contact->phone }}
                @endif
            </div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $contact->subject ?? 'Aucun sujet' }}
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Reçu le {{ \Carbon\Carbon::parse($contact->created_at)->locale('fr')->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
            </p>
        </div>

        <!-- Message -->
        <div class="prose prose-gray dark:prose-invert max-w-none">
            <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $contact->message }}</p>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex justify-end gap-3">
            <a
                href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject ?? 'Votre message') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2"
            >
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Répondre
            </a>

            <form
                action="{{ route('admin.contact.destroy', $contact->id) }}"
                method="POST"
                onsubmit="return confirm('Voulez-vous supprimer ce message ?');"
            >
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2"
                >
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
