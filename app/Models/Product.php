<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property Carbon|null $set_to_commentable_at
 * @property Carbon|null $set_to_votable_at
 * @property Carbon|null $set_to_publicly_reviewable
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Provider $provider
 */
class Product extends Model
{
    use HasFactory;

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
