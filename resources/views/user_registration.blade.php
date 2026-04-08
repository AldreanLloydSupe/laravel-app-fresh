<x-layout title="User Registration">
    <div class="max-w-6xl mx-auto p-6 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">User Registration</h1>
                <p class="mt-2 text-sm text-gray-300">Add, edit, and remove users.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-xl bg-green-600/20 border border-green-500 p-4 text-green-100">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-xl bg-red-600/20 border border-red-500 p-4 text-red-100">
                <strong>There were some problems with your submission.</strong>
                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[420px_1fr]">
            <section class="rounded-3xl bg-slate-900/90 p-6 shadow-lg shadow-black/20">
                <h2 class="text-xl font-semibold text-white mb-4">{{ $editingUser ? 'Edit User' : 'Register New User' }}</h2>

                <form method="POST" action="{{ $editingUser ? url('/users/'.$editingUser->id) : url('/user_registration') }}">
                    @csrf

                    @if($editingUser)
                        @method('PUT')
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-white" for="first_name">First name</label>
                            <input id="first_name" name="first_name" type="text" value="{{ old('first_name', optional($editingUser)->first_name) }}" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white" for="last_name">Last name</label>
                            <input id="last_name" name="last_name" type="text" value="{{ old('last_name', optional($editingUser)->last_name) }}" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white" for="middle_name">Middle name</label>
                            <input id="middle_name" name="middle_name" type="text" value="{{ old('middle_name', optional($editingUser)->middle_name) }}" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white" for="nickname">Nickname</label>
                            <input id="nickname" name="nickname" type="text" value="{{ old('nickname', optional($editingUser)->nickname) }}" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white" for="email">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email', optional($editingUser)->email) }}" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white" for="age">Age</label>
                            <input id="age" name="age" type="number" min="0" max="150" value="{{ old('age', optional($editingUser)->age) }}" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white" for="address">Address</label>
                            <textarea id="address" name="address" rows="2" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500">{{ old('address', optional($editingUser)->address) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white" for="contact_number">Contact number</label>
                            <input id="contact_number" name="contact_number" type="text" value="{{ old('contact_number', optional($editingUser)->contact_number) }}" class="mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950/80 px-3 py-2 text-white outline-none focus:border-indigo-500">
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit" class="rounded-full bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                {{ $editingUser ? 'Update User' : 'Save User' }}
                            </button>

                            @if($editingUser)
                                <a href="{{ url('/user_registration') }}" class="text-sm text-slate-300 hover:text-white">Cancel edit</a>
                            @endif
                        </div>
                    </div>
                </form>
            </section>

            <section class="rounded-3xl bg-slate-900/90 p-6 shadow-lg shadow-black/20 overflow-x-auto">
                <h2 class="text-xl font-semibold text-white mb-4">Registered Users</h2>

                <table class="min-w-full divide-y divide-slate-700 text-left text-sm text-slate-200">
                    <thead class="border-b border-slate-700 text-slate-300">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Age</th>
                            <th class="px-4 py-3">Contact</th>
                            <th class="px-4 py-3">Address</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-800/80">
                                <td class="px-4 py-3">{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->age ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $user->contact_number ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $user->address ?? '—' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap space-x-2">
                                    <a href="{{ url('/users/'.$user->id.'/edit') }}" class="rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-500">Edit</a>
                                    <form method="POST" action="{{ url('/users/'.$user->id) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-500" onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-400">No users registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</x-layout>
