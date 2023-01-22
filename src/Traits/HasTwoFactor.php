<?php

namespace RedRockDigital\Api\Traits;

use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasTwoFactor
{
    /**
     * @return array
     */
    public function recoveryCodes(): array
    {
        return json_decode($this->two_factor_recovery_codes, true);
    }

    /**
     * @return string
     */
    public function generateRecoveryCodes(): string
    {
        return json_encode(Collection::times(8, function () {
            return Str::random(8).'-'.Str::random(8);
        })->all());
    }

    /**
     * @return string
     */
    public function twoFactorQrCodeSvg(): string
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(
                    192,
                    0,
                    null,
                    null,
                    Fill::uniformColor(
                        new Rgb(255, 255, 255),
                        new Rgb(45, 55, 72)
                    )
                ),
                new SvgImageBackEnd()
            )
        ))->writeString($this->twoFactorQrCodeUrl());

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

    /**
     * @return string
     */
    public function twoFactorQrCodeUrl(): string
    {
        $google2fa = app('pragmarx.google2fa');

        if ($this->two_factor_secret === null) {
            $this->forceFill([
                'two_factor_secret' => $google2fa->generateSecretKey(),
            ])->save();

            $this->refresh();
        }

        return $google2fa->getQRCodeUrl(
            config('app.name'),
            $this->email,
            $this->two_factor_secret
        );
    }

    /**
     * @return bool
     */
    public function getTwoFactorEnabledAttribute(): bool
    {
        return (bool) $this->two_factor_secret;
    }

    /**
     * @return bool
     */
    public function getTwoFactorVerifiedAttribute(): bool
    {
        return $this->two_factor_verified_at > $this->last_logged_in_at;
    }
}
