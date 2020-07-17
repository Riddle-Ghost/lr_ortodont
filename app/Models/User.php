<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Airlock\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship to Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Get clinic's info.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clinicInfo()
    {
        return $this->hasOne('App\Models\ClinicInfo');
    }

    /**
     * Get doctor's info.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function doctorInfo()
    {
        return $this->hasOne('App\Models\DoctorInfo');
    }

    /**
     * Clinics by doctor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clinics()
    {
        return $this->belongsToMany(
            'App\Models\User',
            'doctor_clinic',
            'doctor_id',
            'clinic_id'
        );
    }

    /**
     * Doctors by clinic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function doctors()
    {
        return $this->belongsToMany(
            'App\Models\User',
            'doctor_clinic',
            'clinic_id',
            'doctor_id'
        );
    }

    /**
     * Get clinic's orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordersForClinic()
    {
        return $this->hasMany('App\Models\Order', 'clinic_id', 'id');
    }

    /**
     * Get doctor's orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordersForDoctor()
    {
        return $this->hasMany('App\Models\Order', 'doctor_id', 'id');
    }

    /**
     * Send e-mail verification mail
     *
     * @param string|null $password
     */
    public function sendEmailVerificationNotification(string $password = null)
    {
        $this->notify(new VerifyEmailNotification($password));
    }

    /**
     * Scope a query to only include admins users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins($query)
    {
        return $query->where('role_id', Role::ADMIN_ID);
    }
}
