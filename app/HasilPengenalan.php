<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilPengenalan extends Model
{
    //
    protected $table = 'hasil_pengenalan';

    protected $primaryKey = 'id_hasil_pengenalan';

	public $timestamps = false;

    protected $fillable = [
        'id_img_character',
        'target_outputs',
        'created_at'
    ];

    protected $guarded = [];
}
