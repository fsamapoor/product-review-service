<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\StoreReviewAction;
use App\Exceptions\ReviewException;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ReviewController extends Controller
{
    public function store(
        StoreReviewRequest $request,
        StoreReviewAction $storeReviewAction,
        Product $product,
    ): JsonResponse {
        try {
            $reviewDTO = $request->getReviewDTO($product);

            $storeReviewAction->handle($reviewDTO);

            return response()->json([], Response::HTTP_CREATED);
        } catch (Throwable $exception) {
            logger()
                ->channel('review')
                ->error(
                    $exception->getMessage(),
                    isset($reviewDTO) ? $reviewDTO->logContext() : [],
                );

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
