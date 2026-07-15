<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController; 
use App\Http\Controllers\LecturerActionController;
use App\Http\Controllers\ForumController;          
use App\Http\Controllers\QuizController;           
use App\Http\Controllers\AdminDashboardController; 
use App\Http\Controllers\DashboardController; // 🌟 Imported the new controller
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use App\Models\Announcement;
use App\Models\Quiz;                               
use App\Models\Topic;                              
use App\Models\User;                               
use App\Models\Grade;
use Illuminate\Http\Request;

// 1. Public Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// 📥 MANDATORY RULES - ISOLATED TO PREVENT LOOPS
Route::middleware(['auth'])->group(function () {
    Route::get('/rules', function () {
        return view('rules.show');
    })->name('rules.show');

    Route::post('/rules/accept', function (Request $request) {
        $userId = Auth::id();
        User::where('id', $userId)->update([
            'rules_accepted_at' => now()
        ]);

        if (Auth::check()) {
            Auth::user()->refresh();
        }

        return redirect('/dashboard')->with('success', 'Rules accepted successfully!');
    })->name('rules.accept');
});

// 2. Debugging Utility
Route::get('/debug-user', function() {
    $user = Auth::user();
    if (!$user) return "No user is logged in.";
    dd($user->toArray());
})->middleware(['auth']);

// 3. Smart Dynamic Redirection Layer
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) return redirect()->route('login');

    $role = strtolower(trim($user->role ?? ''));
    if ($role === 'administrator' || $role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'lecturer' || $role === 'teacher') return redirect()->route('lecturer.dashboard');
    
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified', \App\Http\Middleware\CheckUserCompliance::class])->name('dashboard');

// 4. Authenticated Role Dashboards & Action Workspace Group
Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckUserCompliance::class])->group(function () {
    
    // 📢 Announcement Management Hooks
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // 📝 Lecturer Academic Operations Hooks
    Route::post('/lecturer/quiz', [LecturerActionController::class, 'storeQuiz'])->name('lecturer.storeQuiz');
    Route::patch('/lecturer/quiz/{quiz}/toggle', [LecturerActionController::class, 'toggleQuizStatus'])->name('lecturer.toggleQuiz');
    Route::delete('/lecturer/quiz/{quiz}', [LecturerActionController::class, 'destroyQuiz'])->name('lecturer.destroyQuiz');
    Route::post('/lecturer/topic', [LecturerActionController::class, 'storeTopic'])->name('lecturer.storeTopic');

    // Forums & Quizzes Workspace
    Route::get('/forum/topic/{topic}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/topic/{topic}/reply', [ForumController::class, 'storeReply'])->name('forum.reply.store');
    Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

    // Resolution Hook for marking accepted answers
    Route::post('/forum/topic/{topic}/resolve/{reply}', function(Topic $topic, $replyId) {
        if (Gate::denies('manage-topic-resolution', $topic)) {
            abort(403, 'Unauthorized action.');
        }
        $topic->update([
            'is_resolved' => true,
            'accepted_reply_id' => $replyId
        ]);
        return redirect()->back()->with('success', 'Marked as accepted answer.');
    })->name('topic.resolve');

    // ==========================================================
    // Upgraded Admin Moderation & User Management Operations Hooks (Connected to Controller)
    // ==========================================================
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/groups/store', [AdminDashboardController::class, 'storeGroup'])->name('admin.storeGroup'); 
    Route::put('/admin/user/{id}', [AdminDashboardController::class, 'update'])->name('admin.user.update'); 
    Route::post('/admin/user/{id}/warn', [AdminDashboardController::class, 'warn'])->name('admin.user.warn');
    Route::post('/admin/user/{id}/restrict', [AdminDashboardController::class, 'restrict'])->name('admin.user.restrict');
    Route::post('/admin/user/{id}/activate', [AdminDashboardController::class, 'activate'])->name('admin.user.activate');
    Route::post('/admin/user/{id}/deactivate', [AdminDashboardController::class, 'deactivate'])->name('admin.user.deactivate');
    Route::post('/admin/user/{id}/reset-warnings', [AdminDashboardController::class, 'resetWarnings'])->name('admin.user.reset-warnings');
    Route::post('/admin/topic/{id}/moderate/{status}', [AdminDashboardController::class, 'moderateTopic'])->name('admin.topic.moderate');

    // 🎓 Student Dashboard Panel (Fixed: Pointed safely to DashboardController)
    Route::get('/student/dashboard', [DashboardController::class, 'studentIndex'])->name('student.dashboard');

    // 👨‍🏫 Upgraded Lecturer Portal Entry Point
    Route::get('/lecturer/dashboard', [LecturerActionController::class, 'index'])->name('lecturer.dashboard');

    // Profile & Cohort Workspace Synchronization Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/group', [ProfileController::class, 'updateGroup'])->name('profile.updateGroup'); 
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';