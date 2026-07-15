<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Store a newly created announcement in the database.
     */
    public function store(Request $request)
    {
        // 1. Validate the form inputs coming from the Admin or Lecturer dashboard
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|string|in:all,student,lecturer',
        ]);

        // 2. Create the announcement mapped explicitly to the database layout columns
        Announcement::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'target_audience' => $validated['target_audience'],
        ]);

        // 3. Redirect back to the dashboard with a success banner notice
        return back()->with('success', 'Announcement published and broadcasted successfully!');
    }
}