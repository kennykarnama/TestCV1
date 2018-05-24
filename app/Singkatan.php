<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Singkatan extends Model
{
    //
    protected $table = 'singkatan';

    protected $primaryKey = 'id_singkatan';

	public $timestamps = false;

    protected $fillable = [
        'kata_singkatan',
        'nama_singkatan',
        'is_approved',
        'created_at',
        'deleted_at'
    ];

    protected $guarded = [];
}
