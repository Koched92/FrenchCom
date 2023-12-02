<?php

namespace App\Controller\Admin;

use App\Entity\Link;
use App\Form\LinkHasCategoryType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

/**
 * @SuppressWarnings(CouplingBetweenObjects)
 */
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
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            TextField::new('name'),
            ImageField::new('icon')->hideOnForm(),
            UrlField::new('url'),
            AssociationField::new('tags')->formatValue(function ($value, $entity) {
                return implode(', ', $entity->getTags()->toArray());
            })->setFormTypeOptions([
                'by_reference' => false,
            ]),
            TextEditorField::new('description')->setTemplatePath('admin/description.html.twig'),

            AssociationField::new('linkHasCategories')->formatValue(function ($value, $entity) {
                $categoryNames = $entity->getLinkHasCategories()->map(function ($linkHasCategory) {
                    return $linkHasCategory->getCategory()->getName();
                });

                return implode(', ', $categoryNames->toArray());
            })->setLabel('Category')->setFormTypeOptions([
                'by_reference' => false,
            ])->hideOnForm(),

            AssociationField::new('linkHasCategories')->formatValue(function ($value, $entity) {
                $categoryGroupNames = $entity->getLinkHasCategories()->map(function ($linkHasCategory) {
                    return $linkHasCategory->getCategoryGroup()->getName();
                });

                return implode(', ', $categoryGroupNames->toArray());
            })->setLabel('Group')->setFormTypeOptions([
                'by_reference' => false,
            ])->hideOnForm(),
            CollectionField::new('linkHasCategories')
                ->setEntryType(LinkHasCategoryType::class)
                ->allowDelete()
                ->allowAdd()
                ->hideOnIndex(),

            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Links')
            // the help message displayed to end users (it can contain HTML tags)
            ->setHelp('index', 'All links available')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setSearchFields(['tags.name', 'url', 'linkHasCategories.categoryGroup.name', 'linkHasCategories.category.name']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
