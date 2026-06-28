<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $photo
 * @property string|null $bio
 * @property string|null $tagline
 * @property string|null $instagram
 * @property string|null $twitter
 * @property string|null $email
 */
class AuthorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'bio',
        'tagline',
        'instagram',
        'twitter',
        'email',
    ];
}
