<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

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
 * @property Collection<int, Review> $reviews
 *
 * @method published()
 */
class Product extends Model
{
    use HasEagerLimit;
    use HasFactory;

    protected $casts = [
        'set_to_commentable_at' => 'datetime',
        'set_to_votable_at' => 'datetime',
        'set_to_publicly_reviewable' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function latestApprovedComments(): HasMany
    {
        return $this->reviews()
            ->approved()
            ->hasComment()
            ->latest()
            ->limit(3);
    }
}
