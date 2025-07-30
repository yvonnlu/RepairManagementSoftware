<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'device_type',
        'issue_category',
        'description',
        'cost_price',
        'current_stock',
        'min_stock_level',
        'location',
        'total_in',
        'total_out',
        'last_movement_date',
        'last_movement_type',
        'last_movement_reason',
        'last_movement_quantity',
        'last_movement_notes',
        'last_order_id'
    ];

    protected $casts = [
        'cost_price' => 'integer',
        'last_movement_date' => 'datetime'
    ];

    // Helper methods
    public function isLowStock()
    {
        return $this->current_stock <= $this->min_stock_level;
    }

    public function getStockStatusAttribute()
    {
        if ($this->current_stock <= 0) {
            return 'Out of Stock';
        } elseif ($this->isLowStock()) {
            return 'Low Stock';
        }
        return 'In Stock';
    }

    public function getStockStatusColorAttribute()
    {
        if ($this->current_stock <= 0) {
            return 'bg-red-100 text-red-800';
        } elseif ($this->isLowStock()) {
            return 'bg-yellow-100 text-yellow-800';
        }
        return 'bg-green-100 text-green-800';
    }

    // Scope để tìm parts theo service
    public function scopeForService($query, $deviceType, $issueCategory)
    {
        return $query->where('device_type', $deviceType)
            ->where('issue_category', $issueCategory);
    }

    // Relationship với Order cho last_order_id
    public function lastOrder()
    {
        return $this->belongsTo(Order::class, 'last_order_id');
    }

    /**
     * Process inventory movement (in/out)
     * 
     * @param string $type 'in' or 'out'
     * @param int $quantity
     * @param string $reason
     * @param int|null $orderId
     * @param string|null $notes
     * @return bool
     */
    public function processMovement($type, $quantity, $reason, $orderId = null, $notes = null)
    {
        // Validate input
        if (!in_array($type, ['in', 'out']) || $quantity <= 0) {
            return false;
        }

        // Check stock for 'out' movement
        if ($type === 'out' && $this->current_stock < $quantity) {
            return false; // Insufficient stock
        }

        // Update stock
        if ($type === 'in') {
            $this->current_stock += $quantity;
            $this->total_in += $quantity;
        } else {
            $this->current_stock -= $quantity;
            $this->total_out += $quantity;
        }

        // Update movement tracking
        $this->last_movement_date = now();
        $this->last_movement_type = $type;
        $this->last_movement_reason = $reason;
        $this->last_movement_quantity = $quantity;
        $this->last_movement_notes = $notes;
        $this->last_order_id = $orderId;

        return $this->save();
    }

    /**
     * Add stock (convenience method)
     */
    public function addStock($quantity, $reason = 'purchase', $notes = null)
    {
        return $this->processMovement('in', $quantity, $reason, null, $notes);
    }

    /**
     * Remove stock (convenience method)
     */
    public function removeStock($quantity, $reason = 'repair_used', $orderId = null, $notes = null)
    {
        return $this->processMovement('out', $quantity, $reason, $orderId, $notes);
    }
}
