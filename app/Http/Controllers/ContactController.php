<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Affiche tous les contacts
    public function index()
    {
        $contacts = Contact::all();
        return view('contact.index', compact('contacts'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('contact.create');
    }

    // Stocke un nouveau contact
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'status' => 'unread',
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => 'Message envoyé avec succès !']);
            }

            return redirect()->back()->with('success', 'Contact créé avec succès');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Erreur lors de l’envoi.'], 500);
            }
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    // Affiche un contact spécifique
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact.show', compact('contact'));
    }

    // Formulaire d'édition
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact.edit', compact('contact'));
    }

    // Met à jour un contact
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        try {
            $contact->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ]);

            return redirect()->back()->with('success', 'Contact mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    // Supprime un contact
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        try {
            $contact->delete();
            return redirect()->back()->with('success', 'Contact supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    // Basculer le statut entre lu et non lu
    public function toggleStatus($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = $contact->status === 'read' ? 'unread' : 'read';
        $contact->save();

        return redirect()->back()->with('success', 'Statut du contact mis à jour avec succès');
    }
}
