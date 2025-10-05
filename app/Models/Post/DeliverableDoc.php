<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class DeliverableDoc extends Model
{
    protected $table = 'deliverable_docs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'postal_id',
        'doc_type',
        'uid',
        'name',
    ];
}
