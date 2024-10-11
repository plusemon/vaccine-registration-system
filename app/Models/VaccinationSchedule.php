<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\VaccinationScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vaccination_date',
        'status',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
