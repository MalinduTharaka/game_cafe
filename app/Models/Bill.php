<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'duration',
        'amount',
        'discount_availability',
        'discount_amount',
        'date',
        'total_amount',
    ];

    /**
     * Get the device associated with the bill.
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
