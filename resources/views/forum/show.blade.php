<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topic->title }} - SmartForum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 mb-6 inline-block">⬅️ Back to Dashboard</a>

        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>
        @endif

        <div class="p-6 bg-white border rounded-2xl shadow-sm mb-6 space-y-3">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-xl font-extrabold text-slate-900">{{ $topic->title }}</h2>
                @if($topic->is_resolved)
                    <span class="px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full shrink-0">✓ Resolved</span>
                @endif
            </div>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $topic->content }}</p>
            <div class="text-xs text-slate-400 font-medium">👁️ {{ $topic->views_count }} views</div>
        </div>

        <div class="space-y-3 mb-6">
            <h3 class="text-sm font-bold text-slate-900">Stream Contributions ({{ $topic->replies->count() }})</h3>
            @foreach($topic->replies as $reply)
                @php
                    $isAccepted = $topic->accepted_reply_id == $reply->id;
                @endphp
                <div class="p-4 bg-white border rounded-xl shadow-sm transition {{ $isAccepted ? 'border-2 border-green-500 bg-green-50/20' : '' }}">
                    <div class="flex items-start justify-between gap-4 mb-1">
                        <div>
                            <span class="text-xs font-bold text-slate-900">{{ $reply->user->name }}</span>
                            @if($isAccepted)
                                <span class="ml-2 px-2 py-0.5 text-[10px] font-extrabold bg-green-600 text-white rounded shadow-sm">✓ Accepted Answer</span>
                            @endif
                        </div>

                        @if(!$topic->is_resolved && Gate::allows('manage-topic-resolution', $topic))
                            <form action="{{ route('topic.resolve', [$topic->id, $reply->id]) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="text-[11px] px-2.5 py-1 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-sm transition cursor-pointer">
                                    ✓ Accept Answer
                                </button>
                            </form>
                        @endif
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed mt-1">{{ $reply->content }}</p>
                </div>
            @endforeach
        </div>

        <div class="p-6 bg-white border rounded-2xl shadow-sm">
            @if(Auth::user()->status === 'restricted')
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs font-medium text-center">
                    ⚠️ Your account execution permissions are temporarily restricted by an administrator. Writing contributions to discussion streams is locked.
                </div>
            @else
                <form action="{{ route('forum.reply.store', $topic->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <textarea name="content" rows="3" required class="w-full p-3 border rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Type your contribution to this stream here..."></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl shadow-sm hover:bg-blue-700 transition cursor-pointer">Post Contribution</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</body>
</html>