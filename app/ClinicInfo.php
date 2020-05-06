<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ClinicInfo extends Model
{
    protected $fillable = [
        'legal_name',
        'address',
        'legal_address',
        'requisites',
        'photo'
    ];

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $baseArray = parent::toArray();

        if ($baseArray['photo'] !== null) {
            $baseArray['photo'] = Storage::url($baseArray['photo']);
        }

        return $baseArray;
    }
}
