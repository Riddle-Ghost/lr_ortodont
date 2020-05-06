<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Admin's id in database.
     */
    const ADMIN_ID = 1;

    /**
     * Doctor's id in database.
     */
    const DOCTOR_ID = 2;

    /**
     * Clinic's id in database.
     */
    const CLINIC_ID = 3;
}
