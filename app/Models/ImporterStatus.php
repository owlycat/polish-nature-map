<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImporterStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_name',
        'job_status',
        'job_timestamp',
    ];
}
