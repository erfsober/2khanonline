<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Order extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const PAYMENT_PENDING = 'pending';

    public const PAYMENT_APPROVED = 'approved';

    public const PAYMENT_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'amount',
        'address',
        'status',
        'payment_status',
        'gateway',
        'transaction_id',
        'reference_id',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('receipt')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->performOnCollections('receipt');
    }

    public function getReceiptUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('receipt') ?: null;
    }

    public function getReceiptThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('receipt', 'thumb') ?: null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }
}
