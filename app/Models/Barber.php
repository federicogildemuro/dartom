<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Barber extends Model
{
    use SoftDeletes, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'photo'];
}
