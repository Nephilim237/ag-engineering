<?php

namespace App\Controller\Admin;

use App\Entity\Testimony;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TestimonyCrudController extends AbstractCrudController
{
    const UPLOAD_TESTIMONY_BASE_PATH = 'uploads/images/testimonies';
    const UPLOAD_TESTIMONY_ROOT_PATH = 'public/uploads/images/testimonies';

    public static function getEntityFqcn(): string
    {
        return Testimony::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index', 'Avis & témoignages')
            ->setPageTitle('new', 'Ajouter un nouvel élément');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('username', 'Nom'),
            TextField::new('title', 'Profession ou Fonction'),
            TextEditorField::new('advice', 'Témoignage'),
            IntegerField::new('rate', 'Note'),
            TextField::new('imageFile', 'Illustration')
                ->hideOnIndex()
                ->setFormType(VichImageType::class)->setColumns('col-sm-12 col-md-3'),
            ImageField::new('userImage', 'Illustration')
                ->hideOnForm()
                ->setBasePath(self::UPLOAD_TESTIMONY_BASE_PATH)
                ->setUploadDir(self::UPLOAD_TESTIMONY_ROOT_PATH)
                ->setSortable(false),
            TextEditorField::new('description', 'Description'),
        ];
    }
}
