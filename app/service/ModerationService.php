<?php

namespace App\Services;

use Illuminate\Support\Str;

class ModerationService
{
    protected $prohibitedKeywords = ['spamlink', 'buyproduct', 'freemoney', 'offensiveword'];

    public function analyzeContent(string $text): array
    {
        $lowercaseText = Str::lower($text);
        
        // 1. Scan for forbidden strings
        foreach ($prohibitedKeywords as $keyword) {
            if (Str::contains($lowercaseText, $keyword)) {
                return ['approved' => false, 'reason' => 'Prohibited commercial marketing or spam keywords detected.'];
            }
        }

        // 2. Scan for character flooding or empty character spamming
        if (strlen($text) > 10 && preg_match('/(.)\1{4,}/', $text)) {
            return ['approved' => false, 'reason' => 'Repetitive character sequence flooding detected.'];
        }

        return ['approved' => true, 'reason' => null];
    }
}