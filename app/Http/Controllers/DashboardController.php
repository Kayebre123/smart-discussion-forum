<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Topic;
use App\Models\Quiz;
use App\Models\Group;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Handle the student dashboard layout rendering view queries.
     */
    public function studentIndex()
    {
        $user = Auth::user();
        $myGroupId = $user->group_id; // Read the single group assigned to the student

        // 1. Fetch announcements deployed to this student's group
        $announcements = Announcement::where('group_id', $myGroupId)->latest()->get();

        // 2. Fetch discussion streams assigned to this student's group
        $topics = Topic::where('group_id', $myGroupId)
            ->where('moderation_status', 'approved')
            ->latest()
            ->get();

        // 3. 🌟 FIXED: Fetch only the quizzes explicitly deployed to this student's group
        $quizzes = Quiz::where('group_id', $myGroupId)->latest()->get();

        // 4. Gather unresolved questions feed for this specific group
        $unansweredQuestions = Topic::where('group_id', $myGroupId)
            ->where('is_resolved', false)
            ->where('moderation_status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        // 5. Global groups available for the select drop-down list
        $allGroups = Group::all();

        return view('student.dashboard', compact(
            'announcements',
            'topics',
            'quizzes',
            'unansweredQuestions',
            'allGroups'
        ));
    }
}