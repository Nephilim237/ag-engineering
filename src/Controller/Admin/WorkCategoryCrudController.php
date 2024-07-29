<?php

namespace App\Controller\Admin;

use App\Entity\WorkCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Catégorie des travaux'),
        ];
    }
}
