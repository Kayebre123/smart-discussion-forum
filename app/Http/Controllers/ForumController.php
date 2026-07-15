<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Render the individual thread discussion stream
    public function show(Topic $topic)
    {
        $topic->increment('views_count');
        
        $topic->load(['user', 'replies.user']);
        
        return view('forum.show', compact('topic'));
    }

    // Process and store the student's response form submission
    public function storeReply(Request $request, Topic $topic)
    {
        $request->validate([
            'content' => 'required|string|min:2'
        ]);

        Reply::create([
            'content' => $request->content,
            'topic_id' => $topic->id,
            'user_id' => Auth::id(),
            'moderation_status' => 'approved', // Safely default to approved directly
        ]);

        return redirect()->back()->with('success', 'Your reply has been posted to the stream successfully!');
    }
}