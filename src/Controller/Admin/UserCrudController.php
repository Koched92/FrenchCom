<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /**
     *  @SuppressWarnings(UnusedFormalParameter)
     *  @SuppressWarnings(StaticAccess)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            TextField::new('firstName'),
            TextField::new('lastName'),
            EmailField::new('email'),
            BooleanField::new('isVerified'),
            BooleanField::new('isApproved'),
            ChoiceField::new('roles')->setChoices([
                'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
            ])->setRequired(false)->allowMultipleChoices(true),
            TextField::new('plainPassword')->hideOnIndex(),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
        ];
    }
}
