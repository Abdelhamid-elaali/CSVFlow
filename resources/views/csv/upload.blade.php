<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl gradient-text">
            {{ __('Upload CSV File') }}
        </h2>
        <p class="mt-1" style="color: rgba(255, 255, 255, 0.6);">Import your user data quickly and securely</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8 animate-slide-in">
                @if (session('message'))
                    <div class="alert alert-success">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('message') }}
                    </div>
                @endif

                <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- File Upload Area -->
                    <div>
                        <label class="block text-sm font-medium mb-3" style="color: rgba(255, 255, 255, 0.8);">
                            Choose your CSV file
                        </label>
                        <div class="file-input-wrapper">
                            <label class="file-input-label flex-col" id="file-drop-zone">
                                <svg class="animate-float" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span class="text-lg font-medium mt-2">Drop your file here</span>
                                <span class="text-sm mt-1" style="color: rgba(255, 255, 255, 0.5);">or click to
                                    browse</span>
                                <span id="file-name" class="mt-3 text-sm font-medium" style="color: #667eea;"></span>
                            </label>
                            <input id="csv_file" type="file" name="csv_file" accept=".csv,.txt"
                                onchange="updateFileName(this)">
                        </div>
                        <p class="mt-2 text-xs" style="color: rgba(255, 255, 255, 0.4);">
                            Accepted formats: CSV, TXT • Max size: 10MB
                        </p>
                    </div>

                    @error('csv_file')
                        <div class="alert alert-error">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-primary flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload & Process
                        </button>
                    </div>
                </form>

                <!-- Features Section -->
                <div class="mt-10 pt-8 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4"
                        style="color: rgba(255, 255, 255, 0.5);">
                        How it works
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-start gap-3 p-4 rounded-lg"
                            style="background: rgba(255, 255, 255, 0.03);">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                                style="background: var(--gradient-primary);">
                                <span class="text-white text-sm font-bold">1</span>
                            </div>
                            <div>
                                <p class="font-medium" style="color: rgba(255, 255, 255, 0.9);">Upload</p>
                                <p class="text-sm" style="color: rgba(255, 255, 255, 0.5);">Select your CSV file</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 rounded-lg"
                            style="background: rgba(255, 255, 255, 0.03);">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                                style="background: var(--gradient-primary);">
                                <span class="text-white text-sm font-bold">2</span>
                            </div>
                            <div>
                                <p class="font-medium" style="color: rgba(255, 255, 255, 0.9);">Review</p>
                                <p class="text-sm" style="color: rgba(255, 255, 255, 0.5);">Verify imported data</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 rounded-lg"
                            style="background: rgba(255, 255, 255, 0.03);">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                                style="background: var(--gradient-primary);">
                                <span class="text-white text-sm font-bold">3</span>
                            </div>
                            <div>
                                <p class="font-medium" style="color: rgba(255, 255, 255, 0.9);">Confirm</p>
                                <p class="text-sm" style="color: rgba(255, 255, 255, 0.5);">Save verified records</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateFileName(input) {
                const fileName = input.files[0]?.name;
                const fileNameSpan = document.getElementById('file-name');
                if (fileName) {
                    fileNameSpan.textContent = '📄 ' + fileName;
                }
            }

            // Drag and drop enhancement
            const dropZone = document.getElementById('file-drop-zone');
            const fileInput = document.getElementById('csv_file');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.style.borderColor = 'rgba(102, 126, 234, 0.8)';
                    dropZone.style.background = 'rgba(102, 126, 234, 0.15)';
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.style.borderColor = 'rgba(255, 255, 255, 0.3)';
                    dropZone.style.background = 'rgba(255, 255, 255, 0.05)';
                });
            });
        </script>
    @endpush
</x-app-layout>