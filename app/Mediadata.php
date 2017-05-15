<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mediadata extends Model
{
    protected $table = 'mediadata';
    protected $fillable = [ 'moviepath', 'moviefilename',
                            'imagepath', 'imagefilename',
                            'nametitle', 'datetitle',
                            'durationtitle', 'cam_id', 'framerate', 'bitrate',
                            'size', 'datemovie'];

    public function size()
    {
        $sum = DB::table($this->table)->sum('size');
        return ceil($sum / 1024);
    }

    public function lastrecord()
    {
        $lastrecord = DB::table($this->table)->latest()->first();
        return $lastrecord;
    }

    public function firstrecord()
    {
        $firstrecord = DB::table($this->table)->first();
        return $firstrecord;
    }

}
