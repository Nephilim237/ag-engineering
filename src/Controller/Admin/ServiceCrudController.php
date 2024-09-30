<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ServiceCrudController extends AbstractCrudController
{
    public const UPLOAD_SERVICE_BASE_PATH = 'uploads/images/services';
    public const UPLOAD_SERVICE_ROOT_PATH = 'public/uploads/images/services';
    const UPLOAD_SERVICE_ICONS_BASE_PATH = 'uploads/images/services/icons';
    const UPLOAD_SERVICE_ICONS_ROOT_PATH = 'public/uploads/images/services/icons';

    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index', 'Prestations & Services')
            ->setPageTitle('new', 'Ajouter Un Nouveau Service')
            ->setPaginatorPageSize(10)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Titre'),
            TextField::new('imageFile', 'Image illustrative')
                ->hideOnIndex()
                ->setFormType(VichImageType::class),
            ImageField::new('serviceImage', 'Image illustrative')
                ->hideOnForm()
                ->setBasePath(self::UPLOAD_SERVICE_BASE_PATH)
                ->setUploadDir(self::UPLOAD_SERVICE_ROOT_PATH)
                ->setSortable(false),
            TextField::new('iconImage', 'Icone descriptive')
                ->hideOnIndex()
                ->setFormType(VichImageType::class),
            ImageField::new('icon', 'Icone descriptive')
                ->hideOnForm()
                ->setBasePath(self::UPLOAD_SERVICE_ICONS_BASE_PATH)
                ->setUploadDir(self::UPLOAD_SERVICE_ICONS_ROOT_PATH)
                ->setSortable(false),
            TextEditorField::new('description')->setFormType(CKEditorType::class)->hideOnIndex(),
        ];
    }
}
