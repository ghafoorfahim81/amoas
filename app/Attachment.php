<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';

    protected $fillable = [
        'label', 'path', 'mime_type', 'attachable_id', 'attachable_type',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
