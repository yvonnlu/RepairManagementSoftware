<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceImageController extends Controller
{
    /**
     * Upload image for a service
     */
    public function upload(Request $request, Services $service)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048', // 2MB max
        ]);

        try {
            $image = $request->file('image');

            // Generate filename
            $deviceFolder = $service->device_folder;
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $filename = Str::slug($originalName) . '.' . $extension;

            // Create directory if not exists
            $uploadPath = public_path("images/services/{$deviceFolder}");
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Delete old image if exists
            if ($service->image && $service->hasImage()) {
                $oldImagePath = public_path($service->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Move uploaded file
            $image->move($uploadPath, $filename);

            // Update service record
            $service->update(['image' => $filename]);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'image_url' => $service->image_url,
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete image for a service (soft delete)
     */
    public function delete(Services $service)
    {
        try {
            if ($service->image && $service->hasImage()) {
                $deviceFolder = $service->device_folder;
                $currentImagePath = public_path($service->image_path);

                if (file_exists($currentImagePath)) {
                    // Create deleted folder if not exists
                    $deletedPath = public_path("images/services/{$deviceFolder}/deleted");
                    if (!file_exists($deletedPath)) {
                        mkdir($deletedPath, 0755, true);
                    }

                    // Create timestamped filename for soft delete
                    $timestamp = date('Y-m-d_H-i-s');
                    $deletedFilename = $timestamp . '_' . $service->image;
                    $deletedFilePath = $deletedPath . '/' . $deletedFilename;

                    // Move file to deleted folder instead of deleting
                    rename($currentImagePath, $deletedFilePath);
                }

                // Update service record to remove image reference
                $service->update(['image' => null]);

                return response()->json([
                    'success' => true,
                    'message' => 'Image moved to trash successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image to delete'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore a deleted image
     */
    public function restore(Services $service, Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        try {
            $deviceFolder = $service->device_folder;
            $deletedFilename = $request->filename;
            $deletedFilePath = public_path("images/services/{$deviceFolder}/deleted/{$deletedFilename}");

            if (!file_exists($deletedFilePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Deleted image not found'
                ], 404);
            }

            // Extract original filename (remove timestamp prefix)
            $originalFilename = preg_replace('/^\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}_/', '', $deletedFilename);
            $restorePath = public_path("images/services/{$deviceFolder}/{$originalFilename}");

            // If service already has an image, move it to deleted first
            if ($service->image && $service->hasImage()) {
                $currentImagePath = public_path($service->image_path);
                if (file_exists($currentImagePath)) {
                    $timestamp = date('Y-m-d_H-i-s');
                    $backupFilename = $timestamp . '_' . $service->image;
                    $backupPath = public_path("images/services/{$deviceFolder}/deleted/{$backupFilename}");
                    rename($currentImagePath, $backupPath);
                }
            }

            // Move restored image back to active folder
            rename($deletedFilePath, $restorePath);

            // Update service record
            $service->update(['image' => $originalFilename]);

            return response()->json([
                'success' => true,
                'message' => 'Image restored successfully',
                'image_url' => $service->image_url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Restore failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get image info for a service
     */
    public function show(Services $service)
    {
        $deletedImages = [];

        // Check for deleted images
        $deletedFolder = public_path("images/services/{$service->device_folder}/deleted");
        if (file_exists($deletedFolder)) {
            $files = glob($deletedFolder . "/*.*");
            foreach ($files as $file) {
                $filename = basename($file);
                // Extract original filename (remove timestamp prefix)
                $originalName = preg_replace('/^\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}_/', '', $filename);

                $deletedImages[] = [
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'deleted_at' => date('Y-m-d H:i:s', filemtime($file)),
                    'size' => filesize($file)
                ];
            }

            // Sort by deletion time (newest first)
            usort($deletedImages, function ($a, $b) {
                return $b['deleted_at'] <=> $a['deleted_at'];
            });
        }

        return response()->json([
            'has_image' => $service->hasImage(),
            'image_url' => $service->image_url,
            'image_name' => $service->image_name,
            'image_path' => $service->image_path,
            'default_icon' => $service->default_icon,
            'deleted_images' => $deletedImages
        ]);
    }
}
