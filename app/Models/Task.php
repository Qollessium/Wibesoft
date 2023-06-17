<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'is_done',
        'starts_at',
        'ends_at'
    ];

    public function users(){
        return $this->belongsToMany(User::class)
        ->withPivot(['is_done', 'assigned_at']);
    }
}
