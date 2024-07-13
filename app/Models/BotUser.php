<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BotUser extends Model
{
    use HasFactory;

    protected $fillable = ["telegram_id","telegram_name", "modme_company_id"];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
