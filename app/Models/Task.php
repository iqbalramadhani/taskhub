<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Kolom dasar P4 — akan ditambah priority, due_date, is_completed di P5
    protected $fillable = ['project_id', 'user_id', 'title', 'description', 'priority', 'due_date', 'is_completed'];

    // Task dimiliki SATU Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Task dimiliki SATU User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function isOverdue(): bool
    {
        return ! $this->is_completed
            && $this->due_date !== null
            && $this->due_date->isPast();
    }

    // app/Models/Task.php -- tambahkan relasi
    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }

    // Relasi: Task punya banyak Tag (many-to-many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag', 'task_id', 'tag_id')->withPivot('tag_id');
    }

    // Catatan: Eloquent otomatis mencari tabel pivot "task_tag"
    // berdasarkan konvensi nama (huruf kecil, diurutkan alfabet)
}
