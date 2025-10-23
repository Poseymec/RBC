<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;


class NewsletterController extends Controller
{
    // Affiche toutes les Newsletter
    public function index()
    {
        $letters = Newsletter::all(); // récupère toutes les Newsletter
        return view('newsletter.index', compact('letters'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('newsletter.create');
    }

    // Stocke une nouvelle newsletter
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            Newsletter::create([
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => 'Merci pour votre abonnement !']);
            }

            return redirect()->back()->with('success', 'Newsletter créée avec succès');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Cet email est déjà abonné.'], 422);
            }
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }
    // Affiche une newsletter
    public function show($id)
    {
        $letter = Newsletter::findOrFail($id);
        return view('newsletter.show', compact('letter'));
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $letter = Newsletter::findOrFail($id);
        return view('newsletter.edit', compact('letter'));
    }

    // Met à jour une newsletter
    public function update(Request $request, $id)
    {
        $letter = Newsletter::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:newsletters,email,' . $letter->id,
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $letter->update([
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return redirect()->back()->with('success', 'Newsletter mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    // Supprime une newsletter
    public function destroy($id)
    {
        $letter = Newsletter::findOrFail($id);
        try {
            $letter->delete();
            return redirect()->back()->with('success', 'Newsletter supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
