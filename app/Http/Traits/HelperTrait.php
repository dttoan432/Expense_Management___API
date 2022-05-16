<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Trait HelperTrait
 * @package App\Traits
 */
trait HelperTrait
{
    /**
     * Lấy url của file từ google drive.
     *
     * @param $fileName
     * @return string|null
     */
    public function getUrlFileFromGoogleDrive($fileName)
    {
        try {
            $file = collect(Storage::disk('google')->listContents('/', false))
                ->where('type', 'file')
                ->where('name', $fileName)
                ->first();

            return Storage::disk('google')->url($file['basename']);
        } catch (\Exception $e) {
            Log::error('Không thể lấy đường dẫn file từ google drive.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Lấy url của file từ storage.
     *
     * @param $fileName
     * @return string|null
     */
    public function getUrlFileFormStorage($fileName)
    {
        try {
            return url(Storage::url($fileName));
        } catch (\Exception $e) {
            Log::error('Không thể lấy đường dẫn file từ storage.', [
                'method' => __METHOD__,
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }
}
