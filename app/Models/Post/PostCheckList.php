<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostCheckList extends Model
{
    //
    public $timestamps = false;

    protected $table = 'post_checklists';

    protected $fillable = ['name', 'status'];

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
