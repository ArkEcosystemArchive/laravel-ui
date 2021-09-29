<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Models;

use ARKEcosystem\Fortify\Models\Concerns\HasLocalizedTimestamps;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\PersonalDataExport\ExportsPersonalData;
use Spatie\PersonalDataExport\PersonalDataSelection;

class UserWithoutVerification extends Authenticatable implements ExportsPersonalData
{
    use HasFactory;
    use HasLocalizedTimestamps;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array|bool
     */
    protected $guarded = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new UserFactory();
    }

    /**
     * @codeCoverageIgnore
     */
    public function selectPersonalData(PersonalDataSelection $personalData): void
    {
        $personalData->add('user.json', [
            'name'  => $this->name,
            'email' => $this->email,
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function personalDataExportName(): string
    {
        return 'personal-data-'.Str::slug($this->name).'.zip';
    }
}
