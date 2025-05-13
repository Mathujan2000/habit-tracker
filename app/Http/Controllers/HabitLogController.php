<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;

class HabitLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'habit_id' => 'required|exists:habits,id',
            'date' => 'required|date',
        ]);

        HabitLog::updateOrCreate(
            ['habit_id' => $request->habit_id, 'date' => $request->date],
            ['completed' => $request->has('completed')]
        );

        return back()->with('success', 'Log opgeslagen.');
    }
}
