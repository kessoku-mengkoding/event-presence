<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;
    use HasUuids;

    public function groupmembers(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }

}
