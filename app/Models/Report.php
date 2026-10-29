<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'p1_first_name',
        'p1_last_name',
        'p1_dob',
        'p1_life_path',
        'p1_destiny',
        'p1_soul',
        'p1_personality',
        'p2_first_name',
        'p2_last_name',
        'p2_dob',
        'p2_life_path',
        'p2_destiny',
        'p2_soul',
        'p2_personality',
        'compatibility_score',
        'summary_en',
        'summary_ta',
        'status',
        'admin_notes',
        'emailed_at',
    ];

    protected function casts(): array
    {
        return [
            'p1_dob' => 'date',
            'p2_dob' => 'date',
            'emailed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return in_array($this->status, ['approved', 'emailed'], true);
    }

    public function getPerson1FullNameAttribute(): string
    {
        return trim($this->p1_first_name . ' ' . $this->p1_last_name);
    }

    public function getPerson2FullNameAttribute(): string
    {
        return trim($this->p2_first_name . ' ' . $this->p2_last_name);
    }
}
