<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KritikSaran extends Model
{
    //
    protected $table = 'kritik_saran';

    protected $primaryKey = 'id_kritik_saran';

	public $timestamps = false;

    protected $fillable = [
        'konten',
        'sent_by_user',
        'has_been_read',
        'created_at',
        'deleted_at'
    ];

    protected $guarded = [];
}
