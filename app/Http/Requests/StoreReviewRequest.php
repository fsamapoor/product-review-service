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

    public const string PRODUCT_ID = 'product_id';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,array<string>>
     */
    public function rules(): array
    {
        return [
            self::PRODUCT_ID => [
                'required',
                'int',
                'exists:App\Models\Product,id',
            ],
            self::Comment => [
                'required_without:' . self::VOTE,
                'string',
                'max:2000',
            ],
            self::VOTE => [
                'required_without:' . self::Comment,
                'int',
                'in:' . implode(',', ReviewRating::values()),
            ],
        ];
    }

    public function getReviewDTO(): ReviewDTO
    {
        /** @var User $user */
        $user = User::factory()->create();
        // TODO:: replace with auth()->user()

        return new ReviewDTO(
            comment: $this->get(self::Comment),
            vote: $this->get(self::VOTE) ? ((int) $this->get(self::VOTE)) : null,
            product: Product::find($this->get(self::PRODUCT_ID)),
            reviewStatus: ReviewStatus::PENDING,
            user: $user,
        );
    }
}
