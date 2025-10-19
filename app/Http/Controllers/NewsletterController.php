<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsLetters;

class NewsLetterController extends Controller
{
    // Affiche toutes les newsletters
    public function index()
    {
        $letters = NewsLetters::all(); // récupère toutes les newsletters
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
            'email' => 'required|email|unique:news_letters,email',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            NewsLetters::create([
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return redirect()->back()->with('success', 'Newsletter créée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    // Affiche une newsletter
    public function show($id)
    {
        $letter = NewsLetters::findOrFail($id);
        return view('newsletter.show', compact('letter'));
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $letter = NewsLetters::findOrFail($id);
        return view('newsletter.edit', compact('letter'));
    }

    // Met à jour une newsletter
    public function update(Request $request, $id)
    {
        $letter = NewsLetters::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:news_letters,email,' . $letter->id,
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
        $letter = NewsLetters::findOrFail($id);
        try {
            $letter->delete();
            return redirect()->back()->with('success', 'Newsletter supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
