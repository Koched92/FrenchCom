<?php

namespace App\Controller\Admin;

use App\Entity\LinkEntity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LinkEntityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LinkEntity::class;
    }

    /**
     * @SuppressWarnings(UnusedFormalParameter)
     * @SuppressWarnings(StaticAccess)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextField::new('url'),
        ];
    }
}
