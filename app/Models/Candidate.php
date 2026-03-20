<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

   protected $fillable = [
    'uuid',
    'candidate_id',
    'first_name',
    'last_name',
    'phone',
    'whatsapp_number',
    'email',
    'passport_number',
    'indian_experience_years',
    'overseas_experience_years',
    'trade_name',
    'industry_type',
    'resume_path',
    'resume_original_name',
    'resume_size',
    'resume_mime_type',
    'status',
    'verification_status', // Add this
    'verification_notes',   // Add this
    'registered_from_ip',
    'registered_from_device',
    'registered_at',
    'user_id',
    'verified_by',
    'verified_at',
];

    protected $casts = [
        'indian_experience_years' => 'integer',
        'overseas_experience_years' => 'integer',
        'registered_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    // Relationship with User (the user account)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with User who verified the candidate
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relationship with documents
    public function documents()
    {
        return $this->hasMany(CandidateDocument::class);
    }

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Accessor for total experience
    public function getTotalExperienceAttribute()
    {
        return $this->indian_experience_years + $this->overseas_experience_years;
    }

    // Accessor for resume URL
    public function getResumeUrlAttribute()
    {
        if ($this->resume_path) {
            return asset('storage/' . $this->resume_path);
        }
        return null;
    }

    // Boot method to generate UUID and candidate ID
    protected static function booted()
    {
        static::creating(function ($candidate) {
            $candidate->uuid = (string) \Str::uuid();
            $candidate->candidate_id = self::generateCandidateId();
            $candidate->registered_at = now();
        });
    }

    // Generate unique candidate ID
    protected static function generateCandidateId()
    {
        $prefix = 'CAN';
        $year = date('Y');
        $month = date('m');
        
        $lastCandidate = self::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->latest('id')
                            ->first();
        
        if ($lastCandidate) {
            $lastNumber = intval(substr($lastCandidate->candidate_id, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . $year . $month . $newNumber;
    }

    // Scopes for filtering
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'fully_verified');
    }

    public function scopeByTrade($query, $trade)
    {
        return $query->where('trade_name', 'like', "%{$trade}%");
    }
}