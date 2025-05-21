<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPersen extends Model
{
    use HasFactory;
    protected $table = 'bank_persen';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'dpu',
        'angsuran',
        'jasa',
        'provisi',
    ];
}
