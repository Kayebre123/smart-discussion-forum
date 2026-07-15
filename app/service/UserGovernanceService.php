<?php

namespace App\Services;

use App\Models\User;

class UserGovernanceService
{
    public function issueWarning(User $user, string $reason)
    {
        // Uniform fallback tracking logic using your database column syntax structure
        $user->warning_count = ($user->warning_count ?? 0) + 1;

        if ($user->warning_count === 1) {
            $user->status = 'warning_1';
            $user->save();
        } elseif ($user->warning_count === 2) {
            $user->status = 'warning_2';
            $user->save();
        } elseif ($user->warning_count >= 3) {
            $user->status = 'blacklisted';
            $user->blacklist_until = now()->addDays(7); // Default 7 day ban threshold
            $user->save();
        }
        
        $user->touch();
    }

    public function restrictUser(User $user)
    {
        // Fixed to 'blacklisted' with default time so CheckUserCompliance intercepts it instantly
        $user->update([
            'status' => 'blacklisted',
            'blacklist_until' => now()->addDays(7)
        ]);
    }

    public function unrestrictUser(User $user)
    {
        $user->update([
            'status' => 'active',
            'blacklist_until' => null
        ]);
    }
}