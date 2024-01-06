<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\ReviewDTO;
use App\Exceptions\ReviewException;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Pipes\EnsureProductCanBeCommentedOn;
use App\Pipes\EnsureProductCanBeVotedOn;
use App\Pipes\EnsureProductIsPublished;
use App\Pipes\EnsureUserCanReviewTheProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Pipeline;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request): JsonResponse
    {
        // TODO:: refactor to Action class
        try {
            $storeReviewDTO = $request->getStoreReviewDTO();

            Pipeline::send($storeReviewDTO)
                ->through([
                    EnsureUserCanReviewTheProduct::class,
                    EnsureProductIsPublished::class,
                    EnsureProductCanBeCommentedOn::class,
                    EnsureProductCanBeVotedOn::class,
                ])
                ->then(function (ReviewDTO $storeReviewDTO) {
                    Review::createFromDTO($storeReviewDTO);

                    // TODO:: event review submitted
                });

            return response()->json([], Response::HTTP_CREATED);
        } catch (Throwable $exception) {
            logger()
                ->channel('review')
                ->error($exception->getMessage(), $storeReviewDTO->logContext());

            if ($exception instanceof ReviewException) {
                return response()->json([
                    'error' => $exception->getMessage(),
                ], Response::HTTP_FORBIDDEN);
            }

            return response()->json([
                'error' => 'Unexpected error occurred!',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
