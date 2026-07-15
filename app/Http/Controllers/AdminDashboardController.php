<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the comprehensive Admin Console.
     */
    public function index()
    {
        // 1. Fetch all system users to render inside the action table parameters
        $users = User::where('id', '!=', auth()->id())->latest()->get();

        // 2. Fetch structural matrices for groups along with nested student/lecturer lists
        $groups = Group::with(['users'])->get();

        // 3. System Metrics Calculations
        $metrics = [
            'total_accounts'   => User::count(),
            'active_users'     => User::where('status', 'active')->count(),
            'flagged_warnings' => User::where('status', 'like', '%warning%')->count(),
        ];

        return view('admin.dashboard', compact('users', 'groups', 'metrics'));
    }

    /**
     * Store a newly provisioned academic group matrix.
     */
    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:groups,code|max:50',
        ]);

        Group::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'New academic structural matrix provisioned successfully!');
    }

    // Individual action button control routes handlers mapping
    public function warn($id) {
        $user = User::findOrFail($id);
        $user->increment('warnings_count');
        $user->status = 'warning_flagged';
        $user->save();
        return redirect()->back()->with('success', "Compliance warning issued to {$user->name}.");
    }

    public function restrict($id) {
        $user = User::findOrFail($id);
        $user->status = 'restricted';
        $user->save();
        return redirect()->back()->with('success', "Workspace access frozen for {$user->name}.");
    }

    public function activate($id) {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return redirect()->back()->with('success', "Account workspace profile reactivated.");
    }

    public function resetWarnings($id) {
        $user = User::findOrFail($id);
        $user->warnings_count = 0;
        $user->status = 'active';
        $user->save();
        return redirect()->back()->with('success', "Warning counters cleared for {$user->name}.");
    }
}