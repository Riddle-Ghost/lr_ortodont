<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    const WAITING = 1;
    const MODELING = 2;
    const CURE = 3;
    const DONE = 4;
}
