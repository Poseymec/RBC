<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;

class SliderController extends Controller
{
    public function saveslider(Request $request)
    {
        $request->validate([
            'description1' => 'required|string',
            'description2' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $fileNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/slider_images', $fileNameToSave);

        Slider::create([
            'description1' => $request->input('description1'),
            'description2' => $request->input('description2'),
            'image' => $fileNameToSave,
            'status' => 1,
        ]);

        return back()->with('status', 'Slider enregistré avec succès.');
    }

    // 🔥 Nouvelle méthode : suppression directe (AJAX compatible)
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if (Storage::exists("public/slider_images/{$slider->image}")) {
            Storage::delete("public/slider_images/{$slider->image}");
        }

        $slider->delete();

        return response()->json(['success' => 'Slider supprimé avec succès.']);
    }

    public function editeslider($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.editeslider', compact('slider'));
    }

    public function updateslider($id, Request $request)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'description1' => 'required|string',
            'description2' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l’ancienne image
            if ($slider->image && Storage::exists("public/slider_images/{$slider->image}")) {
                Storage::delete("public/slider_images/{$slider->image}");
            }

            $file = $request->file('image');
            $fileNameToSave = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/slider_images', $fileNameToSave);
            $slider->image = $fileNameToSave;
        }

        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->save();

        return redirect()->route('admin.slider')->with('status', 'Slider modifié avec succès.');
    }

    public function unactivateslider($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->status = 0;
        $slider->save();
        return back();
    }

    public function activateslider($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->status = 1;
        $slider->save();
        return back();
    }
}
