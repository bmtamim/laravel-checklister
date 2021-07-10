<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['checklist_groups_id', 'name', 'user_id', 'checklist_id'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'checklist_id', 'id')->whereNull('deleted_at');
    }

    public function user_tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'checklist_id', 'id')->where('user_id', auth()->id());
    }

}
