<?php

namespace App\Models;

use App\Events\UserDeleted;
use App\Observers\UserObserver;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use ProtoneMedia\LaravelVerifyNewEmail\MustVerifyNewEmail;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles, MustVerifyNewEmail, Notifiable, SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'deleted' => UserDeleted::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'delete_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'delete_token',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<string>
     */
    protected $with = [
        'connections',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's contribution.
     */
    public function contribution(): HasOne
    {
        return $this->hasOne(Contribution::class);
    }

    /**
     * Get the characters the user has.
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class)
            ->withCount('statistics');
    }

    /**
     * Get the connections that belong to the user.
     */
    public function connections(): BelongsToMany
    {
        return $this->belongsToMany(Connection::class)
            ->withPivot('identifier');
    }

    /**
     * Get the preferences for the user.
     */
    public function preferences(): BelongsToMany
    {
        return $this->belongsToMany(Preference::class)
            ->using(PreferenceUser::class)
            ->withPivot('value');
    }

    /**
     * Scope a query to only include verified users.
     */
    public function scopeVerified(Builder $query): void
    {
        $query->whereNotNull('email_verified_at');
    }

    /**
     * Determine whether the user has recently performed a deletion request.
     */
    protected function isDeletionThrottled(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => RateLimiter::tooManyAttempts(
                sprintf('delete-account:%d', $attributes['id']),
                1
            )
        );
    }

    /**
     * Determine whether the user has recently been sent a verification email.
     */
    protected function isVerificationEmailThrottled(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => RateLimiter::tooManyAttempts(
                sprintf('verification-email:%d', $attributes['id']),
                1
            )
        );
    }

    /**
     * Get the user's Gravatar URL (if applicable)
     */
    protected function gravatarUrl(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => Gravatar::get($attributes['email'])
        );
    }

    /**
     * Creates a temporary signed URL to confirm user deletion.
     */
    public function deletionUrl(): string
    {
        return URL::temporarySignedRoute(
            'destroy',
            now()->addMinutes(config('auth.verification.expire', 60)),
            ['token' => $this->delete_token]
        );
    }
}
