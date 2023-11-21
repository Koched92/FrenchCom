<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class MaintenanceListener
{
    /**
     * @var array<mixed>
     */
    private array $maintenance;
    private Environment $twig;

    /**
     * @param array<mixed> $maintenance
     */
    public function __construct(array $maintenance, Environment $twig)
    {
        $this->maintenance = $maintenance;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $maintenance = $this->maintenance;
        $isMaintenance = $maintenance['statut'] ?? false;
        $currentIP = $event->getRequest()->getClientIp();
        $ipAuthorized = $maintenance['ipAuthorized'];
        // This will detect if we are in dev environment (app_dev.php)
        // $debug = in_array($this->container->get('kernel')->getEnvironment(), ['dev']);
        // If maintenance is active and in prod environment
        if ($isMaintenance and !in_array($currentIP, $ipAuthorized)) {
            // We load our maintenance template
            $template = $this->twig->render('maintenance/maintenance.html.twig');
            // We send our response with a 503 response code (service unavailable)
            $event->setResponse(new Response($template, 503));
            $event->stopPropagation();
        }
    }
}
