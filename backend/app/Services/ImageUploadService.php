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
            $cloudinaryUrl = $this->uploadToCloudinary($file, $folder);
            
            // If Cloudinary upload succeeded, return the URL
            if ($cloudinaryUrl) {
                Log::info('Image uploaded to Cloudinary', ['url' => $cloudinaryUrl]);
                return $cloudinaryUrl;
            }
            
            // Cloudinary failed, fall back to local storage
            Log::warning('Cloudinary upload failed, falling back to local storage');
        }

        // Use local storage
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
        $cloudName = config('services.cloudinary.cloud_name');
        $apiKey = config('services.cloudinary.api_key');
        $apiSecret = config('services.cloudinary.api_secret');
        
        return !empty($cloudName) && !empty($apiKey) && !empty($apiSecret);
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

            if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
                Log::error('Cloudinary credentials missing');
                return null;
            }

            $timestamp = time();
            
            // Create signature - only include params that need to be signed
            $paramsToSign = [
                'folder' => 'blogapp/' . $folder,
                'timestamp' => $timestamp,
            ];
            
            // Sort and create signature string
            ksort($paramsToSign);
            $signatureParts = [];
            foreach ($paramsToSign as $key => $value) {
                $signatureParts[] = $key . '=' . $value;
            }
            $signatureString = implode('&', $signatureParts) . $apiSecret;
            $signature = sha1($signatureString);

            // Read file content
            $fileContent = file_get_contents($file->getRealPath());
            if ($fileContent === false) {
                Log::error('Could not read uploaded file');
                return null;
            }

            // Upload to Cloudinary using multipart form
            $response = Http::timeout(30)
                ->attach('file', $fileContent, $file->getClientOriginalName())
                ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                    'api_key' => $apiKey,
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                    'folder' => 'blogapp/' . $folder,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $secureUrl = $data['secure_url'] ?? null;
                
                if ($secureUrl) {
                    return $secureUrl;
                }
                
                Log::error('Cloudinary response missing secure_url', ['data' => $data]);
                return null;
            }

            Log::error('Cloudinary upload failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Cloudinary upload exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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
            // URL format: https://res.cloudinary.com/{cloud_name}/image/upload/v{version}/{folder}/{public_id}.{ext}
            $pattern = '/\/v\d+\/(.+)\.\w+$/';
            if (preg_match($pattern, $url, $matches)) {
                $publicId = $matches[1];
                
                $cloudName = config('services.cloudinary.cloud_name');
                $apiKey = config('services.cloudinary.api_key');
                $apiSecret = config('services.cloudinary.api_secret');

                $timestamp = time();
                $paramsToSign = [
                    'public_id' => $publicId,
                    'timestamp' => $timestamp,
                ];
                ksort($paramsToSign);
                $signatureParts = [];
                foreach ($paramsToSign as $key => $value) {
                    $signatureParts[] = $key . '=' . $value;
                }
                $signatureString = implode('&', $signatureParts) . $apiSecret;
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
        $path = $file->store($folder, 'public');
        Log::info('Image uploaded to local storage', ['path' => $path]);
        return $path;
    }
}
