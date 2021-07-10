<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageUpload extends Controller
{
    //
    public function ckeEditorImageUpload(Request $request): JsonResponse
    {
        $task = new Task();
        $task->id = 0;
        $task->exists = true;
        $image = $task->addMediaFromRequest('upload')->toMediaCollection();
        return response()->json([
            'url' => $image->getUrl(),
        ]);
    }
}
