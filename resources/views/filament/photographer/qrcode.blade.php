<div class="flex flex-col items-center justify-center p-6">
    <div class="bg-white p-4 rounded-lg shadow-lg">
        {!! $qrcode !!}
    </div>
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 mb-2">分享链接:</p>
        <div class="flex items-center gap-2">
            <input type="text"
                   value="{{ $url }}"
                   readonly
                   class="px-4 py-2 border rounded-lg text-sm text-gray-700 bg-gray-50 flex-1"
                   onclick="this.select()">
            <button onclick="navigator.clipboard.writeText('{{ $url }}').then(() => alert('链接已复制到剪贴板！'))"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                复制
            </button>
        </div>
    </div>
</div>
