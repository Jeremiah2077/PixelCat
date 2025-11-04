<div class="space-y-4">
    <div class="flex justify-center bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
        <img src="{{ $url }}"
             alt="{{ $photo->original_name }}"
             class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg"
             style="image-rendering: -webkit-optimize-contrast;">
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">文件名</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 ml-7">{{ $photo->original_name }}</p>
        </div>

        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">文件大小</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 ml-7">{{ $photo->file_size_formatted }}</p>
        </div>

        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z" />
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">图片尺寸</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 ml-7">
                @if($photo->width && $photo->height)
                    {{ $photo->width }} × {{ $photo->height }} 像素
                @else
                    未知
                @endif
            </p>
        </div>

        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">下载次数</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 ml-7">{{ $photo->download_count }} 次</p>
        </div>

        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">上传时间</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 ml-7">{{ $photo->created_at->format('Y-m-d H:i') }}</p>
        </div>

        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">MIME 类型</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 ml-7">{{ $photo->mime_type }}</p>
        </div>
    </div>

    <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ $url }}"
           target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            在新窗口打开
        </a>
    </div>
</div>
