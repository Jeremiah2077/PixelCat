<div class="flex flex-row gap-4">
    {{-- 总照片数 --}}
    <div class="flex-1 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-xl p-4 border border-blue-200 dark:border-blue-700">
        <div class="flex flex-col items-center text-center">
            <div class="p-3 bg-blue-500 rounded-lg mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="text-xs text-blue-600 dark:text-blue-300 font-medium">总照片</p>
            <p class="text-3xl font-bold text-blue-900 dark:text-white">{{ $record->photos()->count() }}</p>
        </div>
    </div>

    {{-- 访问次数 --}}
    <div class="flex-1 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-xl p-4 border border-green-200 dark:border-green-700">
        <div class="flex flex-col items-center text-center">
            <div class="p-3 bg-green-500 rounded-lg mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <p class="text-xs text-green-600 dark:text-green-300 font-medium">访问次数</p>
            <p class="text-3xl font-bold text-green-900 dark:text-white">{{ $record->view_count }}</p>
        </div>
    </div>

    {{-- 下载次数 --}}
    <div class="flex-1 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl p-4 border border-purple-200 dark:border-purple-700">
        <div class="flex flex-col items-center text-center">
            <div class="p-3 bg-purple-500 rounded-lg mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
            </div>
            <p class="text-xs text-purple-600 dark:text-purple-300 font-medium">下载次数</p>
            <p class="text-3xl font-bold text-purple-900 dark:text-white">{{ $record->download_count }}</p>
        </div>
    </div>

    {{-- 7天访问 --}}
    <div class="flex-1 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-xl p-4 border border-orange-200 dark:border-orange-700">
        <div class="flex flex-col items-center text-center">
            <div class="p-3 bg-orange-500 rounded-lg mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <p class="text-xs text-orange-600 dark:text-orange-300 font-medium">7天访问</p>
            <p class="text-3xl font-bold text-orange-900 dark:text-white">{{ $record->getRecentAccessesCount() }}</p>
        </div>
    </div>
</div>
