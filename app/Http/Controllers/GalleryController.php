<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Photo;
use App\Models\ProjectAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GalleryController extends Controller
{
    public function show(Request $request, string $token)
    {
        $project = Project::where('share_token', $token)
            ->with([
                'photos' => function ($query) {
                    $query->orderBy('order');
                }
            ])
            ->firstOrFail();

        // 记录访问
        ProjectAccess::create([
            'project_id' => $project->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'accessed_at' => now(),
        ]);

        // 增加访问计数
        $project->incrementViewCount();

        return view('gallery.show', compact('project'));
    }

    public function downloadPhoto(Request $request, string $token, int $photoId)
    {
        $project = Project::where('share_token', $token)->firstOrFail();
        $photo = Photo::where('project_id', $project->id)
            ->where('id', $photoId)
            ->firstOrFail();

        if (!$project->allow_download) {
            abort(403, '该项目不允许下载');
        }

        // 增加下载计数
        $photo->incrementDownloadCount();

        return Storage::download($photo->file_path, $photo->original_name);
    }

    public function downloadAll(Request $request, string $token)
    {
        $project = Project::where('share_token', $token)
            ->with('photos')
            ->firstOrFail();

        if (!$project->allow_download) {
            abort(403, '该项目不允许下载');
        }

        $photos = $project->photos;

        if ($photos->isEmpty()) {
            abort(404, '该项目没有照片');
        }

        // 创建临时zip文件
        $zipFileName = 'project_' . $project->id . '_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // 确保temp目录存在
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($photos as $photo) {
                $filePath = Storage::disk('public')->path($photo->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $photo->original_name);
                    $photo->incrementDownloadCount();
                }
            }
            $zip->close();
        }

        return response()->download($zipPath, $project->title . '.zip')->deleteFileAfterSend(true);
    }

    public function downloadSelected(Request $request, string $token)
    {
        $project = Project::where('share_token', $token)->firstOrFail();

        if (!$project->allow_download) {
            abort(403, '该项目不允许下载');
        }

        $photoIds = $request->input('photos', []);
        $photos = Photo::where('project_id', $project->id)
            ->whereIn('id', $photoIds)
            ->get();

        if ($photos->isEmpty()) {
            abort(404, '没有选择照片');
        }

        // 创建临时zip文件
        $zipFileName = 'selected_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // 确保temp目录存在
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($photos as $photo) {
                $filePath = Storage::disk('public')->path($photo->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $photo->original_name);
                    $photo->incrementDownloadCount();
                }
            }
            $zip->close();
        }

        return response()->download($zipPath, 'selected_photos.zip')->deleteFileAfterSend(true);
    }
}
