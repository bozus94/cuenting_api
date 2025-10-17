<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = [
        "name",
        "is_active",
        "is_default",
        "deleted_at",
    ];

    protected $casts = [
        "deleted_at" => "datetime"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
