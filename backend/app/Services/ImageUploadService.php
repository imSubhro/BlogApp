<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload an image to the appropriate storage (Cloudinary or local).
     */
    public function upload(UploadedFile $file, string $folder = 'blog-images'): ?string
    {
        // Check if Cloudinary is configured
        if ($this->isCloudinaryConfigured()) {
            return $this->uploadToCloudinary($file, $folder);
        }

        // Fall back to local storage
        return $this->uploadToLocal($file, $folder);
    }

    /**
     * Delete an image from storage.
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        // Check if it's a Cloudinary URL
        if (Str::contains($path, 'cloudinary.com') || Str::contains($path, 'res.cloudinary.com')) {
            return $this->deleteFromCloudinary($path);
        }

        // Delete from local storage
        return Storage::disk('public')->delete($path);
    }

    /**
     * Get the full URL for an image.
     */
    public function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If it's already a full URL (Cloudinary), return as-is
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // Return local storage URL
        return asset('storage/' . $path);
    }

    /**
     * Check if Cloudinary is configured.
     */
    protected function isCloudinaryConfigured(): bool
    {
        return !empty(config('services.cloudinary.cloud_name'))
            && !empty(config('services.cloudinary.api_key'))
            && !empty(config('services.cloudinary.api_secret'));
    }

    /**
     * Upload to Cloudinary using HTTP API.
     */
    protected function uploadToCloudinary(UploadedFile $file, string $folder): ?string
    {
        try {
            $cloudName = config('services.cloudinary.cloud_name');
            $apiKey = config('services.cloudinary.api_key');
            $apiSecret = config('services.cloudinary.api_secret');

            $timestamp = time();
            $publicId = $folder . '/' . Str::uuid();
            
            // Create signature
            $params = [
                'public_id' => $publicId,
                'timestamp' => $timestamp,
            ];
            ksort($params);
            $signatureString = http_build_query($params) . $apiSecret;
            $signature = sha1($signatureString);

            // Upload to Cloudinary
            $response = Http::attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                    'api_key' => $apiKey,
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                    'public_id' => $publicId,
                    'folder' => 'blogapp',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['secure_url'] ?? null;
            }

            Log::error('Cloudinary upload failed', ['response' => $response->body()]);
            return null;

        } catch (\Exception $e) {
            Log::error('Cloudinary upload exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Delete from Cloudinary.
     */
    protected function deleteFromCloudinary(string $url): bool
    {
        try {
            // Extract public_id from URL
            // URL format: https://res.cloudinary.com/{cloud_name}/image/upload/v{version}/{public_id}.{ext}
            $pattern = '/\/v\d+\/(.+)\.\w+$/';
            if (preg_match($pattern, $url, $matches)) {
                $publicId = $matches[1];
                
                $cloudName = config('services.cloudinary.cloud_name');
                $apiKey = config('services.cloudinary.api_key');
                $apiSecret = config('services.cloudinary.api_secret');

                $timestamp = time();
                $params = [
                    'public_id' => $publicId,
                    'timestamp' => $timestamp,
                ];
                ksort($params);
                $signatureString = http_build_query($params) . $apiSecret;
                $signature = sha1($signatureString);

                $response = Http::post("https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", [
                    'api_key' => $apiKey,
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                    'public_id' => $publicId,
                ]);

                return $response->successful();
            }
        } catch (\Exception $e) {
            Log::error('Cloudinary delete exception', ['error' => $e->getMessage()]);
        }

        return false;
    }

    /**
     * Upload to local storage.
     */
    protected function uploadToLocal(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'public');
    }
}
