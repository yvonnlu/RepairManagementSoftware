<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use SoftDeletes;

    protected $table = 'services';
    public $timestamps = true;

    protected $fillable = [
        'issue_category_name',
        'description',
        'base_price',
        'device_type_name',
        'image',
        'slug'
    ];

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Get device type folder name
            $deviceFolder = strtolower(str_replace(' ', '-', $this->device_type_name));
            $imagePath = "images/services/{$deviceFolder}/{$this->image}";

            if (file_exists(public_path($imagePath))) {
                return asset($imagePath);
            }
        }
        return null;
    }

    // Get default icon based on device type
    public function getDefaultIconAttribute()
    {
        return match ($this->device_type_name) {
            'Smartphone' => 'smartphone',
            'Tablet' => 'tablet',
            'Desktop PC' => 'monitor',
            'Laptop' => 'laptop',
            'Smartwatch' => 'watch',
            default => 'wrench'
        };
    }

    // Helper method to get device folder name
    public function getDeviceFolderAttribute()
    {
        return strtolower(str_replace(' ', '-', $this->device_type_name));
    }

    // Helper method to check if image exists
    public function hasImage()
    {
        if (!$this->image) return false;

        $imagePath = "images/services/{$this->device_folder}/{$this->image}";
        return file_exists(public_path($imagePath));
    }

    // Get full image path for admin/upload purposes
    public function getImagePathAttribute()
    {
        if ($this->image) {
            return "images/services/{$this->device_folder}/{$this->image}";
        }
        return null;
    }

    // For admin - get just the filename
    public function getImageNameAttribute()
    {
        return $this->image;
    }

    // Generate slug from device type and issue category
    public function generateSlug()
    {
        return strtolower(str_replace(' ', '-', $this->device_type_name . '-' . $this->issue_category_name));
    }

    // Get or generate slug
    public function getSlugAttribute($value)
    {
        if (empty($value)) {
            // Nếu database chưa có slug → tạo mới
            return $this->generateSlug();
        }
        // Nếu database đã có slug → dùng luôn
        return $value;
    }

    // Update slug when saving
    public function save(array $options = [])
    {
        // Auto-generate slug if empty or fields changed
        if (empty($this->slug) || $this->isDirty(['device_type_name', 'issue_category_name'])) {
            $this->slug = $this->generateSlug();
        }

        return parent::save($options);
    }
}
