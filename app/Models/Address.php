<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'zip',
        'country',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
