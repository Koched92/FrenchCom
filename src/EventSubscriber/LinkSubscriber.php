<?php

// src/EventSubscriber/EasyAdminSubscriber.php

namespace App\EventSubscriber;

use App\Entity\Icon;
use App\Entity\Link;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class LinkSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['getFavIcon'],
        ];
    }

    /**
     * @SuppressWarnings(StaticAccess)
     */
    public function getFavIcon(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Link)) {
            return;
        }

        $icon = new Icon();
        $url = $entity->getUrl();
        $routes = new RouteCollection();
        $routes->add('default', new Route('/'));
        $requestContext = new RequestContext();
        if (null !== $url) {
            $requestContext->fromRequest(Request::create($url));
        }
        $urlMatcher = new UrlMatcher($routes, $requestContext);
        $domain = $urlMatcher->getContext()->getHost();

        $faviconLink = 'https://www.google.com/s2/favicons?domain='.$domain.'&sz=128';
        $client = HttpClient::create();

        try {
            $response = $client->request('GET', $faviconLink);
            $headers = $response->getHeaders();
            $fileSize = $headers['content-length'][0];
            $fileSizeInKB = round(floatval($fileSize) / 1024, 2);

            // Set icon
            $icon->setPath($faviconLink);
            $icon->setSize(floatval($fileSizeInKB));
            $icon->setName($domain);
        } catch (\Exception $e) {
            // Handle the exception when the icon is not found
            // Set a default icon
            $icon->setPath('img/default_favicon.png');
            $icon->setSize(0);
            $icon->setName('Default Icon');
        }

        // Définir l'icône pour l'objet Link
        $entity->setIcon($icon);
    }
}
