<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard - SmartForum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">
        
        <aside class="fixed inset-y-0 left-0 w-64 border-r bg-white p-6 flex flex-col justify-between shadow-sm">
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-indigo-600 tracking-tight">SmartForum</h2>
                <nav class="space-y-1 flex flex-col">
                    <a href="#" class="px-4 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-semibold text-sm flex items-center gap-2">
                        <span>📊</span> Cohort Overview
                    </a>
                    <button onclick="openModal('createQuizModal')" class="w-full text-left px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2 transition">
                        <span>📝</span> Deploy New Quiz
                    </button>
                    <button onclick="openModal('createTopicModal')" class="w-full text-left px-4 py-2.5 text-slate-600 hover:bg-slate-50 rounded-xl text-sm flex items-center gap-2 transition">
                        <span>🗣️</span> Launch Topic Seed
                    </button>
                </nav>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-sm transition text-sm cursor-pointer">
                    Logout
                </button>
            </form>
        </aside>

        <div class="flex-1 pl-64">
            <header class="h-16 border-b border-slate-200 bg-white sticky top-0 z-10 px-8 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 font-medium text-sm">Workspace /</span>
                    <h1 class="text-sm font-extrabold text-slate-900">{{ Auth::user()->name }} 🧑‍🏫</h1>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-indigo-50 text-indigo-600">Lecturer Mode</span>
            </header>

            <main class="p-8 max-w-5xl mx-auto space-y-6">
                
                @if(session('success'))
                    <div class="p-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl shadow-sm">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Monitored Cohort Size</span>
                        <h3 class="text-2xl font-black text-slate-900 mt-2">{{ $metrics['total_students'] }} Active Students</h3>
                    </div>
                    <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Class Presence Status</span>
                        <h3 class="text-2xl font-black text-emerald-600 mt-2">{{ $metrics['active_students'] }} Engaged Now</h3>
                    </div>
                    <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Unresolved Questions</span>
                        <h3 class="text-2xl font-black text-indigo-600 mt-2">{{ $metrics['pending_questions'] }} Awaiting</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">📝 Deployed Evaluation Quizzes</h4>
                            <div class="space-y-3">
                                @forelse($quizzes as $quiz)
                                    <div class="p-4 border border-slate-100 bg-slate-50/40 rounded-xl flex justify-between items-center">
                                        <div>
                                            <h5 class="text-xs font-bold text-slate-900">{{ $quiz->title }}</h5>
                                            <span class="text-[10px] text-slate-400 font-medium block mt-1">Target: {{ $quiz->group->name }} | Duration: {{ $quiz->duration_minutes }} Mins</span>
                                        </div>
                                        <span class="px-2.5 py-1 text-[10px] font-bold bg-green-50 text-green-700 rounded-full">Deployed</span>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">No quizzes deployed yet. Click "Deploy New Quiz" on the sidebar to build one!</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">🗣️ Discussion Stream Seeds</h4>
                            <div class="space-y-3">
                                @forelse($topics as $topic)
                                    <div class="p-4 border border-slate-100 bg-slate-50/40 rounded-xl">
                                        <div class="flex justify-between items-start">
                                            <h5 class="text-xs font-bold text-slate-900">{{ $topic->title }}</h5>
                                            <span class="text-[10px] font-bold bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">{{ $topic->group->name }}</span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $topic->content }}</p>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">No discussion seeds created yet.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div class="space-y-6">
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <h4 class="text-sm font-bold text-slate-900 mb-3">🧑‍🎓 Student Cohort Directory</h4>
                            <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2">
                                @forelse($students as $student)
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs font-bold text-slate-800">{{ $student->name }}</span>
                                            <span class="text-[10px] font-medium text-slate-400">Class: {{ $student->group->name ?? 'None' }}</span>
                                        </div>
                                        <div class="flex gap-2 mt-2">
                                            <span class="text-[9px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md font-bold">Topics: {{ $student->topics_count }}</span>
                                            <span class="text-[9px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md font-bold">Replies: {{ $student->replies_count }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">No student records found in your linked cohorts.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="createQuizModal" class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl relative my-8">
            <h3 class="text-base font-bold text-slate-900 mb-2">Create & Deploy Evaluation Quiz</h3>
            <p class="text-xs text-slate-500 mb-6">Build assessment modules containing custom questions and specify weighted marks per problem item.</p>
            
            <form action="{{ route('lecturer.storeQuiz') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Target Student Cohort</label>
                        <select name="group_id" required class="w-full px-3 py-2 border rounded-xl text-xs outline-none bg-white">
                            @foreach($allGroups as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Quiz Title</label>
                        <input type="text" name="title" required placeholder="e.g. Laravel Architecture Quiz" class="w-full px-3 py-2 border rounded-xl text-xs outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Opens Date & Time</label>
                        <input type="datetime-local" name="opens_at" required class="w-full px-3 py-2 border rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Duration (Minutes)</label>
                        <input type="number" name="duration_minutes" required min="1" placeholder="e.g. 15" class="w-full px-3 py-2 border rounded-xl text-xs outline-none">
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-xs font-bold text-slate-900">Quiz Question Items</h4>
                        <button type="button" onclick="addQuestionField()" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">+ Add Question Block</button>
                    </div>
                    
                    <div id="questionsContainer" class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                        <div class="question-block border border-slate-100 p-4 rounded-xl bg-slate-50/50 space-y-3 relative">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-1">Question 1 Text</label>
                                <input type="text" name="questions[0][text]" required placeholder="Enter question..." class="w-full px-3 py-2 border rounded-xl text-xs outline-none bg-white">
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="questions[0][a]" required placeholder="Option A" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                                <input type="text" name="questions[0][b]" required placeholder="Option B" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                                <input type="text" name="questions[0][c]" placeholder="Option C (Optional)" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                                <input type="text" name="questions[0][d]" placeholder="Option D (Optional)" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 mb-0.5">Correct Answer Option</label>
                                    <select name="questions[0][correct]" class="w-full px-3 py-1.5 border rounded-lg text-xs outline-none bg-white font-medium">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 mb-0.5">Allocated Marks</label>
                                    <input type="number" name="questions[0][marks]" value="1" min="1" required class="w-full px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-4">
                    <button type="button" onclick="closeModal('createQuizModal')" class="px-4 py-2 text-xs text-slate-500 hover:bg-slate-50 rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition">Publish Quiz</button>
                </div>
            </form>
        </div>
    </div>

    <div id="createTopicModal" class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl relative">
            <h3 class="text-base font-bold text-slate-900 mb-2">Launch Topic Discussion Seed</h3>
            <p class="text-xs text-slate-500 mb-4">Launch discussion streams that align with specific classes.</p>
            
            <form action="{{ route('lecturer.storeTopic') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Target Cohort Group</label>
                        <select name="group_id" required class="w-full px-3 py-2 border rounded-xl text-xs outline-none bg-white">
                            @foreach($allGroups as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Topic Title</label>
                        <input type="text" name="title" required placeholder="e.g. Discussion on MVC Architectures" class="w-full px-3 py-2 border rounded-xl text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Initial Discussion Seed Content</label>
                        <textarea name="content" required rows="4" placeholder="Type instructions or questions to seed the discussion forum..." class="w-full px-3 py-2 border rounded-xl text-xs outline-none resize-none"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('createTopicModal')" class="px-4 py-2 text-xs text-slate-500 hover:bg-slate-50 rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-sm">Launch Stream</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let questionCount = 1;

        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        // Dynamically appends a new question template block containing the Marks field
        function addQuestionField() {
            const container = document.getElementById('questionsContainer');
            const questionHtml = `
                <div class="question-block border border-slate-100 p-4 rounded-xl bg-slate-50/50 space-y-3 relative">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-3 right-3 text-red-500 hover:text-red-700 text-xs font-bold">Remove</button>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Question ${questionCount + 1} Text</label>
                        <input type="text" name="questions[${questionCount}][text]" required placeholder="Enter question..." class="w-full px-3 py-2 border rounded-xl text-xs outline-none bg-white">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="questions[${questionCount}][a]" required placeholder="Option A" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                        <input type="text" name="questions[${questionCount}][b]" required placeholder="Option B" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                        <input type="text" name="questions[${questionCount}][c]" placeholder="Option C (Optional)" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                        <input type="text" name="questions[${questionCount}][d]" placeholder="Option D (Optional)" class="px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 mb-0.5">Correct Answer Option</label>
                            <select name="questions[${questionCount}][correct]" class="w-full px-3 py-1.5 border rounded-lg text-xs outline-none bg-white font-medium">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 mb-0.5">Allocated Marks</label>
                            <input type="number" name="questions[${questionCount}][marks]" value="1" min="1" required class="w-full px-3 py-1.5 border rounded-lg text-xs outline-none bg-white">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', questionHtml);
            questionCount++;
        }
    </script>
</body>
</html>