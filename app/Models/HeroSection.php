<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $heading
 * @property string|null $subheading
 * @property string|null $body
 * @property string|null $cta_label
 * @property string|null $cta_url
 * @property string|null $image
 * @property bool $is_active
 */
class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'subheading',
        'body',
        'cta_label',
        'cta_url',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
