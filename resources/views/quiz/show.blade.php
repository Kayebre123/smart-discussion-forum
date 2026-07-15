<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Quiz Session</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 p-6 antialiased select-none">
    <div class="max-w-2xl mx-auto space-y-6">
        
        <div class="p-6 bg-white border rounded-2xl shadow-sm flex justify-between items-center">
            <h2 class="text-base font-bold text-slate-900">{{ $quiz->title }}</h2>
            <span class="text-xs font-bold bg-amber-50 text-amber-700 px-3 py-1 rounded-lg">⏱️ Limit: {{ $quiz->duration_minutes }} Mins</span>
        </div>

        <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST" class="space-y-4">
            @csrf
            
            @forelse($questions as $index => $q)
                <div class="p-6 bg-white border rounded-2xl shadow-sm space-y-4">
                    <div class="flex justify-between items-start gap-4">
                        <p class="text-xs font-bold text-slate-900">
                            Q{{ $index + 1 }}. {{ $q['question_text'] }}
                        </p>
                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md whitespace-nowrap">
                            {{ $q['marks'] ?? 1 }} {{ \Illuminate\Support\Str::plural('Mark', $q['marks'] ?? 1) }}
                        </span>
                    </div>

                    <div class="space-y-2">
                        @foreach(($q['options'] ?? []) as $key => $optionValue)
                            @if(!empty($optionValue))
                                <label class="flex items-center gap-3 text-xs cursor-pointer p-2.5 border rounded-xl hover:bg-slate-50/80 transition">
                                    <input type="radio" name="answers[{{ $index }}]" value="{{ $key }}" required class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="font-bold text-slate-500">{{ $key }}.</span>
                                    <span>{{ $optionValue }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="p-8 bg-white border rounded-2xl text-center">
                    <p class="text-xs text-slate-500 italic">No custom questions have been configured for this quiz.</p>
                </div>
            @endforelse

            @if(count($questions) > 0)
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-sm text-xs transition">
                    Submit Final Examination Answers
                </button>
            @endif
        </form>
    </div>
</body>
</html>