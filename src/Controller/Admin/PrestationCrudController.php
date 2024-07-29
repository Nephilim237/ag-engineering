<?php

namespace App\Controller\Admin;

use App\Entity\Prestation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PrestationCrudController extends AbstractCrudController
{
    const UPLOAD_SERVICE_PRESTATIONS_BASE_PATH = 'uploads/images/prestations/icons';
    const UPLOAD_SERVICE_PRESTATIONS_ROOT_PATH = 'public/uploads/images/prestations/icons';

    public static function getEntityFqcn(): string
    {
        return Prestation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Quelle Prestation Proposez-vous?'),
            TextField::new('description', 'Ajouter un bref slogan.'),
            TextField::new('iconImage', 'Icone')
                ->hideOnIndex()
                ->setFormType(VichImageType::class),
            ImageField::new('icon', 'Icone')
                ->hideOnForm()
                ->setBasePath(self::UPLOAD_SERVICE_PRESTATIONS_BASE_PATH)
                ->setUploadDir(self::UPLOAD_SERVICE_PRESTATIONS_ROOT_PATH)
                ->setSortable(false),
        ];
    }
}
