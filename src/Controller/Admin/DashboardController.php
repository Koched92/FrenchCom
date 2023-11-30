<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\CategoryGroup;
use App\Entity\Icon;
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
            ->generateRelativeUrls()
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        /* yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield  MenuItem::section('Links'),

        yield MenuItem::linkToCrud('Links', 'fas fa-list', LinkEntity::class); */

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Links');
        $linkRepository = $this->em->getRepository(Link::class);
        $tagRepository = $this->em->getRepository(Tag::class);
        $categoryGroupsRepository = $this->em->getRepository(CategoryGroup::class);
        $categoryRepository = $this->em->getRepository(Category::class);
        $IconRepository = $this->em->getRepository(Icon::class);
        $linkCount = $linkRepository->count([]);
        $tagCount = $tagRepository->count([]);
        $categoryGroupsCount = $categoryGroupsRepository->count([]);
        $categoryCount = $categoryRepository->count([]);
        $iconCount = $IconRepository->count([]);
        yield MenuItem::linkToCrud('Links', 'fas fa-link', Link::class)
            ->setBadge($linkCount, 'primary');
        yield MenuItem::linkToCrud('Tags', 'fas fa-tags', Tag::class)
            ->setBadge($tagCount, 'primary');
        yield MenuItem::linkToCrud('Category Groups', 'fab fa-elementor', CategoryGroup::class)
            ->setBadge($categoryGroupsCount, 'primary');
        yield MenuItem::linkToCrud('Categories', 'fab fa-elementor', Category::class)
            ->setBadge($categoryCount, 'primary');
        yield MenuItem::linkToCrud('Icons', 'fas fa-icons', Icon::class)
            ->setBadge($iconCount, 'primary');
        yield MenuItem::section('Users');
        $userRepository = $this->em->getRepository(User::class);
        $userCount = $userRepository->count([]);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class)
            ->setBadge($userCount, 'primary');
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
                MenuItem::linkToExitImpersonation('Stop impersonation', 'fas fa-door-open'),
            ]);
    }
}
