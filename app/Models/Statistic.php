<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['stat_key', 'stat_value', 'stat_label', 'icon_class', 'display_order', 'status'];
}
