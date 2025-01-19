<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GmSession extends Model
{
    use HasFactory;

    protected $table = 'gmsessions';

    protected $fillable = ['device_id', 'start_time', 'end_time', 'status'];

    // Relationship with Device
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
