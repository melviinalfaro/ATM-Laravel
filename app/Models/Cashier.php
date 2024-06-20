<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    use HasFactory;

    protected $table = "cashiers";

    protected $fillable = [
        "bills_1",
        "bills_5",
        "bills_10",
        "bills_20",
        "bills_50",
        "bills_100",
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class, "id_cashier");
    }
}
