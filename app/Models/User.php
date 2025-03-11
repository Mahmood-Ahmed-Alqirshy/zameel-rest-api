<?php

namespace App\Models;

use App\Authorization\Abilities;
use App\Authorization\AuthorizationRole;
use App\Exceptions\SendEmailException;
use App\Mail\PasswordResetMail;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ADMIN = 1;

    public const MANAGER = 2;

    public const ACADEMIC = 3;

    public const REPRESENTER = 4;

    public const STUDENT = 5;

    protected $fillable = [
        'name',
        'email',
        'password',
        'group_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $attributes = [
        'role_id' => AuthorizationRole::STUDENT->value,
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function group(): belongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user_members')
            ->using(Member::class);
    }

    public function applies(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user_applies')
            ->using(Apply::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(Assignment::class)->using(Delivery::class);
    }

    // deprecated
    public function abilities()
    {
        return Abilities::getAbilities(AuthorizationRole::from($this->role_id));
    }

    public function sendPasswordResetNotification($token)
    {
        try {
            $link = PasswordResetMail::passwordResetURL($token);
            Mail::to($this->email)->send(new PasswordResetMail($link));
        } catch (Exception $e) {
            throw new SendEmailException('Failed To Send Email.', 502);
        }
    }
}
