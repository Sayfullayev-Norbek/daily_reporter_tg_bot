<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ["name", "modme_company_id", "modme_token", "tariff"];

    public function botuser(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }

    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class, 'modme_company_id', 'modme_company_id');
    }
}
