<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl gradient-text">
                    {{ __('Verify Imported Data') }}
                </h2>
                <p class="mt-1" style="color: rgba(255, 255, 255, 0.6);">Review and confirm your imported records</p>
            </div>
            @if(!$users->isEmpty())
                <div class="flex items-center gap-2 px-4 py-2 rounded-full" style="background: rgba(102, 126, 234, 0.2);">
                    <span class="w-2 h-2 rounded-full animate-pulse" style="background: #667eea;"></span>
                    <span class="text-sm font-medium" style="color: rgba(255, 255, 255, 0.8);">
                        {{ $users->count() }} {{ Str::plural('record', $users->count()) }} pending
                    </span>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8 animate-slide-in">
                @if (session('message'))
                    <div class="alert alert-success">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('message') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ session('warning') }}
                    </div>
                @endif

                @if($users->isEmpty())
                    <!-- Empty State -->
                    <div class="empty-state py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-6"
                            style="background: rgba(255, 255, 255, 0.05);">
                            <svg class="w-10 h-10" style="color: rgba(255, 255, 255, 0.3);" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2" style="color: rgba(255, 255, 255, 0.9);">No records to verify
                        </h3>
                        <p class="mb-6" style="color: rgba(255, 255, 255, 0.5);">Upload a CSV file to get started with
                            importing data.</p>
                        <a href="{{ route('csv.index') }}" class="btn-primary inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload CSV File
                        </a>
                    </div>
                @else
                    <form action="{{ route('csv.confirm') }}" method="POST">
                        @csrf

                        <!-- Table -->
                        <div class="overflow-x-auto rounded-xl" style="background: rgba(0, 0, 0, 0.2);">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">
                                            <input type="checkbox" id="select-all" class="custom-checkbox">
                                        </th>
                                        <th>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" style="color: rgba(255, 255, 255, 0.4);" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                First Name
                                            </div>
                                        </th>
                                        <th>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" style="color: rgba(255, 255, 255, 0.4);" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Last Name
                                            </div>
                                        </th>
                                        <th>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" style="color: rgba(255, 255, 255, 0.4);" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                Telephone
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="verified_ids[]" value="{{ $user->id }}"
                                                    class="custom-checkbox row-checkbox">
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold"
                                                        style="background: var(--gradient-primary);">
                                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                                    </div>
                                                    <span class="font-medium">{{ $user->first_name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>
                                                <span class="px-3 py-1 rounded-full text-sm"
                                                    style="background: rgba(255, 255, 255, 0.1);">
                                                    {{ $user->telephone }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t"
                            style="border-color: rgba(255, 255, 255, 0.1);">
                            <div class="text-sm" style="color: rgba(255, 255, 255, 0.5);">
                                <span id="selected-count">0</span> of {{ $users->count() }} selected
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('csv.index') }}" class="btn-secondary inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Back to Upload
                                </a>
                                <button type="submit" class="btn-success inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Confirm Selected
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
                const selectAll = document.getElementById('select-all');
                const rowCheckboxes = document.querySelectorAll('.row-checkbox');
                const selectedCount = document.getElementById('selected-count');

                function updateSelectedCount() {
                    const checked = document.querySelectorAll('.row-checkbox:checked').length;
                    if (selectedCount) {
                        selectedCount.textContent = checked;
                    }
                }

                if (selectAll) {
                     selectAll.addEventListener('change', function () {
                        rowCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        updateSelectedCount();
                    });
                }

                rowCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        updateSelectedCount();
                        // Update select all checkbox state
                        if (selectAll) {
                            selectAll.checked = document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length;  }
                    });
                });

                // Initial count
                updateSelectedCount();
        </script>
    @endpush
</x-app-layout>