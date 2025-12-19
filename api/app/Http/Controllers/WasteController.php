<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\WasteLog;
use Illuminate\Support\Facades\Storage;

class WasteController extends Controller {
    public function upload(Request $request) {
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg|max:10240']);

        $uploaded = $request->file('image');
        $path = $uploaded->store('wastes', 'public');
        $imageUrl = Storage::url($path);

        $response = Http::attach(
            'file',
            fopen($uploaded->getRealPath(), 'r'),
            $uploaded->getClientOriginalName()
        )->timeout(10)->post('http://ml:9000/vision/analyze-waste');

        if ($response->failed()) {
            return response()->json(['error' => 'AI 分析失敗'], 503);
        }

        $data = $response->json();
        $item = $data['items'][0];

        WasteLog::create([
            'food_category' => $item['food_category'],
            'weight' => $data['total_estimated_weight'],
            'image_path' => $imageUrl,
            'suggestion' => $data['suggestion'] ?? null
        ]);

        return response()->json([
            'message' => '上傳成功',
            'data' => $data,
            'image_url' => url($imageUrl)
        ]);
    }

    public function logs() {
        return WasteLog::latest()->get();
    }

    public function stats() {
        $logs = WasteLog::all();
        return [
            'total_weight' => round($logs->sum('weight'), 2),
            'total_loss' => round($logs->sum('weight') * 200, 0),
            'count' => $logs->count()
        ];
    }
}
