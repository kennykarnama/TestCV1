<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadedFiles extends Model
{
    //
    protected $table = 'uploaded_files';

    protected $primaryKey = 'id_uploaded_file';

	public $timestamps = false;

    protected $fillable = [
        'uploaded_file_path',
        'uploaded_by_user',
        'uploaded_file_extension',
        'uploaded_file_type',
        'uploaded_at',
        'deleted_at'

    ];

    protected $guarded = [];
}
