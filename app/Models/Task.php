<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Task extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'checklist_id',
        'name',
        'description',
        'order',
        'user_id',
        'task_id',
        'completed_at',
        'add_to_my_day',
        'is_important',
        'due_date',
        'reminder_at'
    ];

    protected $dates = [
        'due_date',
        'reminder_at'
    ];

    public function parent_tasks()
    {
        return $this->belongsTo(self::class, 'task_id', 'id');
    }

    public function child_tasks()
    {
        return $this->hasMany(self::class, 'task_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
