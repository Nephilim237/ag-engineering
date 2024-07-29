<?php

namespace App\Controller\Admin;

use App\Entity\OurWork;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OurWorkCrudController extends AbstractCrudController
{
    const UPLOADS_OURWORK_BASE_PATH = 'uploads/images/our_works';
    const UPLOADS_OURWORK_ROOT_PATH = 'public/uploads/images/our_works';

    public static function getEntityFqcn(): string
    {
        return OurWork::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Donnez Un Titre A Votre Réalisation'),
            TextField::new('vichWorkImageFile', 'Ajouter Une Image Illustrative Pour Cette Oeuvre')
                ->hideOnIndex()
                ->setFormType(VichImageType::class),
            ImageField::new('workImage', 'Ajouter Une Image Illustrative Pour Cette Oeuvre')
                ->hideOnForm()
                ->setBasePath(self::UPLOADS_OURWORK_BASE_PATH)
                ->setUploadDir(self::UPLOADS_OURWORK_ROOT_PATH)
                ->setSortable(false),
            TextEditorField::new('description', 'Décrivez Cette Oeuvre'),
            AssociationField::new('workCategory', 'A Quelle Catégorie Appartient Cette Oeuvre?')
        ];
    }
}
