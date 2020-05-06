<?php

namespace App;

use App\Notifications\VerifyEmail;
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
        'name', 'email', 'password', 'phone'
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
        return $this->belongsTo('App\Role');
    }

    /**
     * Get clinic's info.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clinicInfo()
    {
        return $this->hasOne('App\ClinicInfo');
    }

    /**
     * Get doctor's info.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function doctorInfo()
    {
        return $this->hasOne('App\DoctorInfo');
    }

    /**
     * Clinics by doctor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clinics()
    {
        return $this->belongsToMany(
            'App\User',
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
            'App\User',
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
        return $this->hasMany('App\Order', 'clinic_id', 'id');
    }

    /**
     * Get doctor's orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordersForDoctor()
    {
        return $this->hasMany('App\Order', 'doctor_id', 'id');
    }

    /**
     * Send e-mail verification mail
     *
     * @param string|null $password
     */
    public function sendEmailVerificationNotification(string $password = null)
    {
        $this->notify(new VerifyEmail($password));
    }
}
