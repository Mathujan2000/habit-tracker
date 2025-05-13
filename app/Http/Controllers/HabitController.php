<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habit::all();
        return view('habits.index', compact('habits'));
    }

    public function create()
    {
        return view('habits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Habit::create($request->all());
        return redirect()->route('habits.index')->with('success', 'Gewoonte aangemaakt.');
    }

    public function edit(Habit $habit)
    {
        return view('habits.edit', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $habit->update($request->all());
        return redirect()->route('habits.index')->with('success', 'Gewoonte bijgewerkt.');
    }

    public function destroy(Habit $habit)
    {
        $habit->delete();
        return redirect()->route('habits.index')->with('success', 'Gewoonte verwijderd.');
    }
}
