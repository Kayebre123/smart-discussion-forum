<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Grade;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display the custom quiz workspace interface framework to a student.
     */
    public function show(Quiz $quiz)
    {
        // 1. AUTOMATIC CLOSURE VALIDATION: If deadline is exceeded, close access instantly
        if ($quiz->ends_at && now()->greaterThan($quiz->ends_at)) {
            $quiz->update(['is_active' => false]);
            return redirect()->route('student.dashboard')->with('error', 'Access Rejected. This evaluation deadline has passed.');
        }

        // 2. TIMING AVAILABILITY ACCESSIBILITY VALIDATION
        if ($quiz->starts_at && now()->lessThan($quiz->starts_at)) {
            return redirect()->route('student.dashboard')->with('error', 'This assessment quiz is locked until: ' . $quiz->starts_at->format('M d, Y H:i'));
        }

        // 3. RE-SUBMISSION CHECKS
        $alreadyTaken = Grade::where('quiz_id', $quiz->id)->where('student_id', auth()->id())->exists();
        if ($alreadyTaken) {
            return redirect()->route('student.dashboard')->with('error', 'You have already submitted responses for this evaluation module.');
        }

        // 4. DECODE CUSTOM QUESTIONS INSTEAD OF HARDCODING
        $questions = [];
        if (!empty($quiz->custom_questions)) {
            $questions = is_array($quiz->custom_questions) 
                ? $quiz->custom_questions 
                : json_decode($quiz->custom_questions, true);
        }

        return view('quiz.show', compact('quiz', 'questions'));
    }

    /**
     * Handle real-time user evaluations submission grading scripts.
     */
    public function submit(Request $request, Quiz $quiz)
    {
        // 1. TIMING EXPLOIT PREVENTION BLOCK
        if ($quiz->ends_at && now()->greaterThan($quiz->ends_at)) {
            $quiz->update(['is_active' => false]);
            return redirect()->route('student.dashboard')->with('error', 'Submission Rejected. The expiration timeline window passed before you saved your work.');
        }

        // Decode custom questions
        $questions = [];
        if (!empty($quiz->custom_questions)) {
            $questions = is_array($quiz->custom_questions) 
                ? $quiz->custom_questions 
                : json_decode($quiz->custom_questions, true);
        }

        if (count($questions) === 0) {
            return redirect()->route('student.dashboard')->with('error', 'Invalid workspace schema.');
        }

        // 2. PROCESSING EVALUATION SCORES BY CALCULATING TOTAL EARNED VS TOTAL POSSIBLE MARKS
        $totalPossibleMarks = 0;
        $totalEarnedMarks = 0;
        $studentResponses = $request->input('answers', []);

        foreach ($questions as $index => $q) {
            $questionMarks = isset($q['marks']) ? intval($q['marks']) : 1;
            $totalPossibleMarks += $questionMarks;

            $submittedAnswer = $studentResponses[$index] ?? null;
            if ($submittedAnswer && strtoupper($submittedAnswer) === strtoupper($q['correct_answer'] ?? 'A')) {
                $totalEarnedMarks += $questionMarks;
            }
        }

        // Calculate a dynamic percentage score based on custom marks weights
        $finalScore = $totalPossibleMarks > 0 ? ($totalEarnedMarks / $totalPossibleMarks) * 100 : 0;

        // 3. PERSIST RAW RECORD GRADE DATA LAYER (Fixed to supply required database columns)
        Grade::create([
            'quiz_id'         => $quiz->id,
            'student_id'      => auth()->id(),
            'score'           => round($finalScore, 2),
            'assessment_name' => $quiz->title, // 🌟 FIX: Satisfies the SQLite NOT NULL constraint
        ]);

        return redirect()->route('student.dashboard')->with('success', "Evaluation completed! You earned: {$totalEarnedMarks}/{$totalPossibleMarks} Marks (" . round($finalScore) . "%)");
    }
}