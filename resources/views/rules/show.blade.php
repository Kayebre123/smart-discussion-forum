<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Rules Agreement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-md space-y-4">
        
        @if($errors->any())
            <div class="p-3 bg-red-50 text-red-700 text-xs rounded-xl border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <h2 class="text-xl font-bold text-slate-900">Platform Community Guidelines</h2>
        <p class="text-xs text-slate-600 leading-relaxed">
            To participate in forum threads, drop reply responses, submit messages, or take active evaluation quizzes, you must first read and accept our community rules. Respectful collaboration is mandatory.
        </p>
        
        <form action="/rules/accept" method="POST" onsubmit="console.log('Form submitting...');">
            @csrf
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow transition cursor-pointer">
                I Understand and Accept the Rules
            </button>
        </form>
    </div>
</body>
</html>