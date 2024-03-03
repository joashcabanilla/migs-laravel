<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'ElectionStatus',
        'startDateTime',
        'endDateTime',
        'f2fStartDateTime',
        'f2fEndDateTime',
        'MeetingSched',
        'MeetingID',
        'MeetingPass'
    ];
}
