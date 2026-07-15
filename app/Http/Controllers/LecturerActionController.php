<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Topic;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LecturerActionController extends Controller
{
    public function index()
    {
        $lecturer = auth()->user();

        // 1. Get IDs of all groups this lecturer belongs to
        $myGroupIds = $lecturer->groups()->pluck('groups.id')->toArray();

        // 2. ONLY fetch students belonging to those specific groups
        // Eager loads the 'groups' relationship to track cross-referenced memberships
        $students = User::where('role', 'student')
            ->whereIn('group_id', $myGroupIds)
            ->with('groups')
            ->withCount(['topics', 'replies'])
            ->get();

        // 3. Fetch quizzes created by this lecturer targeting their specific groups
        $quizzes = Quiz::where('user_id', $lecturer->id)
            ->whereIn('group_id', $myGroupIds)
            ->with('group')
            ->latest()
            ->get();

        // 4. Populate discussion topics bound exclusively to the lecturer's group scope
        $topics = Topic::where('moderation_status', 'approved')
            ->whereIn('group_id', $myGroupIds)
            ->with('group')
            ->latest()
            ->get();

        // 5. Gather all global groups so the lecturer can attach to new ones inside the modal
        $allGroups = Group::all();

        // 6. Calculate contextual data metrics strictly within the lecturer's cohort footprint
        $metrics = [
            'total_students'    => $students->count(),
            'active_students'   => $students->where('status', 'active')->count(),
            'pending_questions' => Topic::where('is_resolved', false)->where('moderation_status', 'approved')->whereIn('group_id', $myGroupIds)->count(),
            'class_quiz_avg'    => 0, // Calculate using your system's custom grade averaging if tracking metrics
        ];

        return view('lecturer.dashboard', compact('students', 'topics', 'quizzes', 'allGroups', 'metrics'));
    }

    public function storeQuiz(Request $request)
    {
        // 1. Manually type-cast the value directly out of the request payload
        $duration = intval($request->input('duration_minutes'));

        // 2. Validate incoming data (excluding duration_minutes from strict integer checks to prevent interception crashes)
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string|max:255',
            'opens_at' => 'required|date',
            'questions' => 'required|array|min:1',
        ]);

        // 3. Force check to make sure duration is valid manually
        if ($duration < 1) {
            return redirect()->back()->withErrors(['duration_minutes' => 'The duration must be at least 1 minute.']);
        }

        // 4. Safely calculate dates using the isolated primitive integer variable
        $opensAt = Carbon::parse($request->opens_at);
        $endsAt = $opensAt->copy()->addMinutes($duration);

        // 5. Process questions payload array structure (🌟 CAPTURING CUSTOM MARKS PER QUESTION)
        $formattedQuestions = [];
        foreach ($request->questions as $q) {
            if (!empty($q['text'])) {
                $formattedQuestions[] = [
                    'question_text'  => $q['text'],
                    'options'        => [
                        'A' => $q['a'] ?? '', 
                        'B' => $q['b'] ?? '', 
                        'C' => $q['c'] ?? '', 
                        'D' => $q['d'] ?? ''
                    ],
                    'correct_answer' => $q['correct'] ?? 'A',
                    'marks'          => isset($q['marks']) ? intval($q['marks']) : 1 // 🌟 Saves custom marks! Default to 1
                ];
            }
        }

        // 6. Save directly using the isolated integer variable
        Quiz::create([
            'user_id' => auth()->id(),
            'group_id' => $request->group_id,
            'title' => $request->title,
            'opens_at' => $opensAt,
            'ends_at' => $endsAt,
            'duration_minutes' => $duration, // 🌟 Safe primitive int variable
            'custom_questions' => json_encode($formattedQuestions),
        ]);

        return redirect()->back()->with('success', 'Quiz successfully published and deployed to your chosen cohort.');
    }

    public function storeTopic(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
        ]);

        Topic::create([
            'user_id'           => auth()->id(),
            'group_id'          => $request->group_id,
            'title'             => $request->title,
            'content'           => $request->content,
            'moderation_status' => 'approved', // Auto-approve lecturer discussion seeds
            'is_resolved'       => false,
        ]);

        return redirect()->back()->with('success', 'Discussion stream launched successfully for the targeted group!');
    }
}