<?php

namespace App\Controller\Admin;

use App\Entity\CategoryGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 *  @SuppressWarnings(UnusedFormalParameter)
 *  @SuppressWarnings(StaticAccess)
 */
class CategoryGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryGroup::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
        ];
    }
}
