<x-filament-widgets::widget>
    <div class="fi-wi-stats-overview-card relative rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Welcome back, {{ $this->getPhotographer()->name }}!
                </h2>
                <p class="text-gray-600 dark:text-gray-300 text-lg">
                    Manage your photography portfolio with ease
                </p>
            </div>

            <div style="display: grid; grid-template-columns: auto 1fr; gap: 3rem; align-items: center;">
                <!-- Left Column: Buttons Only -->
                <div class="space-y-3 flex flex-col justify-center" style="min-width: 280px; max-width: 400px;">
                    <a href="{{ route('filament.photographer.resources.projects.index') }}"
                       class="group flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 p-4 transition hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-105 border border-gray-200 dark:border-gray-600 w-full">
                        <div class="rounded-lg bg-blue-100 dark:bg-blue-900/30 p-2 mr-3">
                            <svg class="h-6 w-6 text-blue-900 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">My Projects</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">View all projects</p>
                        </div>
                    </a>

                    <a href="{{ route('filament.photographer.resources.projects.create') }}"
                       class="group flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 p-4 transition hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-105 border border-gray-200 dark:border-gray-600 w-full">
                        <div class="rounded-lg bg-blue-100 dark:bg-blue-900/30 p-2 mr-3">
                            <svg class="h-6 w-6 text-blue-900 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">New Project</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Create a project</p>
                        </div>
                    </a>

                    <a href="https://github.com/Jeremiah2077/PixelCat"
                       target="_blank"
                       class="group flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 p-4 transition hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-105 border border-gray-200 dark:border-gray-600 w-full">
                        <div class="rounded-lg bg-blue-100 dark:bg-blue-900/30 p-2 mr-3">
                            <svg class="h-6 w-6 text-blue-900 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">GitHub</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Open source</p>
                        </div>
                    </a>
                </div>

                <!-- Right Column: Image Only -->
                <div class="flex items-center justify-center">
                    <img src="https://illustrations.popsy.co/blue/photographer.svg"
                         alt="Photography illustration"
                         class="w-full h-auto"
                         style="max-width: 320px;">
                </div>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mt-6">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Share your projects with unique links and track client engagement</span>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
