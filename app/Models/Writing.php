<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $collection_id
 * @property string $title
 * @property string $slug
 * @property string $type
 * @property string|null $excerpt
 * @property string $content
 * @property string|null $thumbnail
 * @property bool $is_published
 * @property int $sort_order
 * @property Carbon|null $written_at
 */
class Writing extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'title',
        'slug',
        'type',
        'excerpt',
        'content',
        'thumbnail',
        'is_published',
        'sort_order',
        'written_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'written_at' => 'date',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $writing) {
            if (empty($writing->slug)) {
                $writing->slug = Str::slug($writing->title);
            }
        });
    }

    /** @return BelongsTo<Collection, $this> */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    /** @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /** @return array<int, string> */
    public static function types(): array
    {
        return ['puisi', 'pantun', 'cerita', 'prosa', 'sajak', 'lainnya'];
    }
}
