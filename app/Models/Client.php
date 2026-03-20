<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'client_id',
        'name',
        'organization_name',
        'phone',
        'whatsapp_number',
        'email',
        'industry_type',
        'status',
        'verification_status',
        'verification_notes',
        'registered_from_ip',
        'registered_from_device',
        'registered_at',
        'user_id',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Boot method
    protected static function booted()
    {
        static::creating(function ($client) {
            $client->uuid = (string) \Str::uuid();
            $client->client_id = self::generateClientId();
            $client->registered_at = now();
        });
    }

    // Generate unique client ID
    protected static function generateClientId()
    {
        $prefix = 'CLI';
        $year = date('Y');
        $month = date('m');
        
        $lastClient = self::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->latest('id')
                            ->first();
        
        if ($lastClient) {
            $lastNumber = intval(substr($lastClient->client_id, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . $year . $month . $newNumber;
    }
}