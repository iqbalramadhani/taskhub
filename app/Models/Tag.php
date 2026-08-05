<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'color'];

    // Relasi: Tag dipakai di banyak Task (many-to-many)
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
