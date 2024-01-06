<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransferObjects\ReviewDTO;
use App\Enums\ReviewRating;
use App\Enums\ReviewStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public const string Comment = 'comment';

    public const string VOTE = 'vote';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,array<string>>
     */
    public function rules(): array
    {
        return [
            self::Comment => [
                'required_without:' . self::VOTE,
                'string',
                'max:2000',
            ],
            self::VOTE => [
                'required_without:' . self::Comment,
                'integer',
                'in:' . implode(',', ReviewRating::values()),
            ],
        ];
    }

    public function getReviewDTO(Product $product): ReviewDTO
    {
        /** @var User $user */
        $user = User::factory()->create();
        // TODO:: replace with auth()->user()

        return new ReviewDTO(
            comment: $this->get(self::Comment),
            vote: $this->get(self::VOTE),
            product: $product,
            reviewStatus: ReviewStatus::PENDING,
            user: $user,
        );
    }
}
