<?php

namespace App\Controller\Admin;

use App\Entity\LinkHasCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class LinkHasCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LinkHasCategory::class;
    }

    /**
     * @SuppressWarnings(UnusedFormalParameter)
     * @SuppressWarnings(StaticAccess)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('categoryGroup'),
            AssociationField::new('category'),
            AssociationField::new('link'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['link.name']);
    }
}
