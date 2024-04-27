<?php

namespace App\Models;

use App\Models\Payment\Deposit;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPermissions;
    use SoftDeletes;

    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    const PIX_TYPE = [
        'email' => 'E-mail',
        'cpf' => 'CPF',
        'phone' => 'Telefone',
        'random' => 'Chave Aleatória',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ref_code',
        'name',
        'email',
        'phone',
        'password',
        'document',
        'currency',
        'comission',//
        'callback',//
        'profile_photo_path',//
        'birth_date',
        'pix_key',
        'pix_key_type',
        'username',
        'affiliate_id',
        'affiliate_percent_revenue_share',
        'affiliate_percent_revenue_share_sub',
        'affiliate_cpa',
        'affiliate_cpa_sub',
        'affiliate_min_deposit_cpa',
        'fake_affiliate_percent_revenue_share',
        'fake_affiliate_percent_revenue_share_sub',
        'fake_affiliate_cpa',
        'fake_affiliate_cpa_sub',
        'fake_affiliate_min_deposit_cpa',
        'is_fake',
        'notify_first_deposit',
        'agent_type',//
        'api_type',//
        'status'//
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        // 'remember_token',

        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function document(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $value,
            set: fn ($value) => preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", preg_replace('/[^0-9]/', '', $value))
        );
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'id', 'user_id')
            ->where('type', 'main')
            ->latest();
    }

    public function wallet_revenue_share(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'id', 'user_id')
            ->where('type', 'affiliate_revenue_share')
            ->latest();
    }

    public function wallet_cpa(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'id', 'user_id')
            ->where('type', 'affiliate_cpa')
            ->latest();
    }

    public function bonuses(): HasMany
    {
        return $this->hasMany(Bonus::class);
    }

    public function bonus(): BelongsTo
    {
        return $this->belongsTo(Bonus::class, 'id', 'user_id')
            ->where('status', true)
            ->where('expiration_at', '>=', now())
            ->latest();
    }

    public function affiliates(): HasMany
    {
        return $this->hasMany(User::class, 'affiliate_id', 'id');
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function games()
    {
        return $this->belongsToMany(Games::class);
    }

    public function gamesBet()
    {
        return $this->hasMany(GamesBet::class);
    }

        public function referencedWithdrawalTransactions(): HasMany
        {
            return $this->hasMany(Transaction::class, 'user_id', 'affiliate_id')
                ->where('name', 'withdrawal');
        }
}
