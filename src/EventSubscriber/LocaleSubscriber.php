<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subscribes to kernel request events to set the locale.
 */
class LocaleSubscriber implements EventSubscriberInterface
{
    /**
     * LocaleSubscriber constructor.
     *
     * @param string $defaultLocale The default locale to use if none is set in the session.
     */
    public function __construct(private readonly string $defaultLocale = 'pl')
    {
    }

    /**
     * Sets the request locale based on the session or query parameter.
     *
     * @param RequestEvent $event The current request event.
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        // jeśli user wybrał _locale na stronie głównej → zapisz w sesji
        if ($request->query->has('_locale')) {
            $session->set('_locale', $request->query->get('_locale'));
        }

        // pobierz z sesji lub ustaw domyślny
        $locale = $session->get('_locale', $this->defaultLocale);
        $request->setLocale($locale);
    }

    /**
     * Returns the subscribed events and their corresponding methods.
     *
     * @return array<string, array<int, array{0:string,1:int}>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
