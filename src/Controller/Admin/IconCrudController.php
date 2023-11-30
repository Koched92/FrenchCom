<?php

namespace App\Controller\Admin;

use App\Entity\Icon;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class IconCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Icon::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex(),
            ImageField::new('path'),
            CollectionField::new('links'),
        ];
    }
}
