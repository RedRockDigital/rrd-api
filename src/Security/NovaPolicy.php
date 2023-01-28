<?php

namespace RedRockDigital\Api\Security;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class NovaPolicy extends Basic
{
    /**
     * @var array
     */
    private array $cloudFrontDirectives = [
        Directive::CONNECT, Directive::FONT, Directive::PREFETCH, Directive::SCRIPT, Directive::STYLE, Directive::IMG,
    ];

    /**
     * @return void
     */
    public function configure(): void
    {
        if (config('app.env') === 'local') {
            return;
        }

        $this->addDirective(Directive::STYLE, 'https://fonts.googleapis.com/');
        $this->addDirective(Directive::STYLE, 'unsafe-inline');

        $this->addDirective(Directive::FONT, 'https://fonts.gstatic.com/');

        $this->addDirective(Directive::SCRIPT, 'https://beacon-v2.helpscout.net/');
        $this->addDirective(Directive::SCRIPT, 'https://js.stripe.com/');
        $this->addDirective(Directive::SCRIPT, 'unsafe-inline');

        $this->addDirective(Directive::FRAME, 'https://js.stripe.com/');

        $this->addDirective(Directive::CONNECT, 'https://d3hb14vkzrxvla.cloudfront.net/');
        $this->addDirective(
            Directive::CONNECT,
            'ws://' . config('broadcasting.connections.pusher.options.host') .
            ':' . config('broadcasting.connections.pusher.options.port')
        );
        $this->addDirective(
            Directive::CONNECT,
            'wss://' . config('broadcasting.connections.pusher.options.host') .
            ':' . config('broadcasting.connections.pusher.options.port')
        );

        foreach ($this->cloudFrontDirectives as $directive) {
            $this->addDirective($directive, asset(''));
        }
    }
}
