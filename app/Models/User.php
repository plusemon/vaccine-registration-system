<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nid',
        'password',
        'scheduled_at',
        'vaccine_center_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'scheduled_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = ['status'];

    /**
     * Get the vaccine center associated with the User
     *
     * @return BelongsTo
     */
    public function vaccineCenter(): BelongsTo
    {
        return $this->belongsTo(VaccineCenter::class);
    }

    public function status(): Attribute
    {
        return new Attribute(
            get: function () {

                if (is_null($this->scheduled_at)) {
                    return 'Not Scheduled';
                }

                if ($this->scheduled_at->isPast()) {
                    return 'Vaccinated';
                }

                return 'Scheduled';
            }
        );
    }

}
