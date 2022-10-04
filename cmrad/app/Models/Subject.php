<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'repository_id'
    ];


    /**
     * Relations
    */
    public function repository()
    {
        return $this->belongTo(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);

    }
}
