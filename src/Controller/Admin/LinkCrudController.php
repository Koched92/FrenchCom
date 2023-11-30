<?php

namespace App\Controller\Admin;

use App\Entity\Link;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class LinkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Link::class;
    }

    /**
     *  @SuppressWarnings(UnusedFormalParameter)
     *  @SuppressWarnings(StaticAccess)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            // hide the id field from being displayed on first page
            IdField::new('id')->hideOnIndex(),
            TextField::new('name'),
           // ImageField::new('icon'),
            UrlField::new('url'),
            AssociationField::new('tags')->formatValue(function ($value, $entity) {
                return implode(', ', $entity->getTags()->toArray());
            }),
            TextEditorField::new('description'),
            CollectionField::new('linkHasCategories')->formatValue(function ($value, $entity) {
                $categoryNames = $entity->getLinkHasCategories()->map(function ($linkHasCategory) {
                    return $linkHasCategory->getCategory()->getName();
                });

                return implode(', ', $categoryNames->toArray());
            })->setLabel('Category'),
            CollectionField::new('linkHasCategories')->formatValue(function ($value, $entity) {
                $categoryGroupNames = $entity->getLinkHasCategories()->map(function ($linkHasCategory) {
                    return $linkHasCategory->getCategoryGroup()->getName();
                });

                return implode(', ', $categoryGroupNames->toArray());
            })->setLabel('Group'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Links')
            // the help message displayed to end users (it can contain HTML tags)
            ->setHelp('index', 'All links available')
            ->setSearchFields(['tags.name', 'url', 'linkHasCategories.categoryGroup.name', 'linkHasCategories.category.name']);
    }
}
