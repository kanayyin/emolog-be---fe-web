<?php
namespace App\Models;
use App\Models\User;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
public $timestamps = false;

    protected $fillable = [
        'username',
        'title',
        'content',
        'mood',
        'diary_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}