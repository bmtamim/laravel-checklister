<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function checklists()
    {
        return $this->hasMany(Checklist::class, 'checklist_groups_id', 'id');
    }
}
