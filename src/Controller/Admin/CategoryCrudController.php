<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    /**
     *  @SuppressWarnings(UnusedFormalParameter)
     *  @SuppressWarnings(StaticAccess)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('categoryGroup')->formatValue(function ($value, $entity) {
                return $entity->getCategoryGroup();
            })->setFormTypeOptions([
                'by_reference' => true,
            ]),
            TextEditorField::new('description'),
            
        ];
    }
}
