<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class ReviewException extends Exception
{
    public static function unpublishedProduct(): self
    {
        return new self('Unpublished products can not be reviewed!');
    }

    public static function uncommentableProduct(): self
    {
        return new self('Comments are not allowed for products that have not been marked as commentable!');
    }

    public static function unvotableProduct(): self
    {
        return new self('Votes are not allowed for products that have not been marked as votable!');
    }

    public static function userHasNotBoughtTheProduct(): self
    {
        return new self('User should buy this product before submitting a review for it!');
    }
}
