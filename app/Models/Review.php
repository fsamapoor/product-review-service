<?php

declare(strict_types=1);

namespace App\Models;

use App\DataTransferObjects\ReviewDTO;
use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $status
 * @property ?string $comment
 * @property ?int $vote
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Product $product
 *
 * @method approved()
 * @method rejected()
 * @method pending()
 * @method hasComment()
 * @method hasVote()
 */
class Review extends Model
{
    use HasEagerLimit;
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', ReviewStatus::APPROVED->value);
    }

    public function scopeRejected(Builder $query): void
    {
        $query->where('status', ReviewStatus::REJECTED->value);
    }

    public function scopePending(Builder $query): void
    {
        $query->where('status', ReviewStatus::PENDING->value);
    }

    public function scopeHasComment(Builder $query): void
    {
        $query->whereNotNull('comment');
    }

    public function scopeHasVote(Builder $query): void
    {
        $query->whereNotNull('vote');
    }

    public static function createFromDTO(ReviewDTO $storeReviewDTO): Review
    {
        /** @var Review $review */
        $review = self::query()->create([
            'user_id' => $storeReviewDTO->user->id,
            'product_id' => $storeReviewDTO->product->id,
            'comment' => $storeReviewDTO->comment,
            'vote' => $storeReviewDTO->vote,
            'status' => $storeReviewDTO->reviewStatus->value,
        ]);

        return $review;
    }
}
