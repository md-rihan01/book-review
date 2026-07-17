<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'rating', 'user_id'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        $bustListing = fn() => cache()->increment('books_listing_version');

        static::updated(function (Review $review) use ($bustListing) {
            cache()->forget('book:' . $review->book_id);
            $bustListing();
        });
        static::deleted(function (Review $review) use ($bustListing) {
            cache()->forget('book:' . $review->book_id);
            $bustListing();
        });
        static::created(function (Review $review) use ($bustListing) {
            cache()->forget('book:' . $review->book_id);
            $bustListing();
        });
    }
}
