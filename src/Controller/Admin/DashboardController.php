<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Link;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @SuppressWarnings(PHPMD)
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FrenchCom')
            ->setFaviconPath('img/favicon.svg')
            ->disableUrlSignatures()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        /* yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield  MenuItem::section('Links'),

        yield MenuItem::linkToCrud('Links', 'fas fa-list', LinkEntity::class); */

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Movies');

        yield MenuItem::linkToUrl('Search in Google', 'fab fa-google', 'https://google.com');
        yield MenuItem::linkToUrl('Search on Facebook', 'fab fa-facebook', 'https://facebook.com');
        yield MenuItem::linkToUrl('Search on YouTube', 'fab fa-youtube', 'https://youtube.com');
        yield MenuItem::section('Books');
        yield MenuItem::section('Series');
        yield MenuItem::section('Intertainments');
        yield MenuItem::section('Users');
        $userRepository = $this->em->getRepository(User::class);
        $linkRepository = $this->em->getRepository(Link::class);
        $tagRepository = $this->em->getRepository(Tag::class);
        $cartegoryRepository = $this->em->getRepository(Category::class);

        $userCount = $userRepository->count([]);
        $linkCount = $linkRepository->count([]);
        $tagCount = $tagRepository->count([]);
        $categoryCount = $cartegoryRepository->count([]);

        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class)
            ->setBadge($userCount, 'primary');
        yield MenuItem::linkToCrud('Links', 'fa fa-user', Link::class)
        ->setBadge($linkCount, 'primary');
        yield MenuItem::linkToCrud('Tags', 'fa fa-user', Tag::class)
        ->setBadge($tagCount, 'primary');
        yield MenuItem::linkToCrud('Categories', 'fa fa-user', Category::class)
        ->setBadge($categoryCount, 'primary');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
        yield MenuItem::linkToExitImpersonation('Stop impersonation', 'fas fa-door-open');
    }

    /**
     * @SuppressWarnings(StaticAccess)
     */
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserName(false)
            ->setAvatarUrl('https://img1.freepng.es/20180425/csw/kisspng-computer-icons-emoticon-emoji-smiley-evil-5ae11c681c99e7.6968052915247023121172.jpg')
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
            ]);
    }
}
