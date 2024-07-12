<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['modme_company_id', 'rating', 'rating_label'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'modme_company_id');
    }
}
