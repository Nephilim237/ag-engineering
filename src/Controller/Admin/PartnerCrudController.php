<?php

namespace App\Controller\Admin;

use App\Entity\Partner;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PartnerCrudController extends AbstractCrudController
{
    public const UPLOAD_PARTNER_BASE_PATH = 'uploads/images/partners';
    public const UPLOAD_PARTNER_ROOT_PATH = 'public/uploads/images/partners';

    public static function getEntityFqcn(): string
    {
        return Partner::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index', 'Liste Des Partenaires')
            ->setPageTitle('new', 'Ajouter un Partenaire')
            ->setPaginatorPageSize(50);
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->update('index', 'new', function (Action $action) {
                return $action
                    ->setLabel('Nouveau Partenaire')
                    ->setIcon('fa-solid fa-handshake')
                    ->setCssClass('text-capitalize');
            })
            ->update('index', Action::EDIT, function (Action $action) {
                return $action
                    ->setLabel('Modifier')
                    ->setIcon('far fa-edit')
                    ->setCssClass('text-capitalize');
            })
            ->update('index', Action::BATCH_DELETE, function (Action $action) {
                return $action
                    ->setLabel('Supprimer')
                    ->setIcon('fa-solid fa-trash-can')
                    ->setCssClass('text-capitalize');
            })
            ->update('new', Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel('Sauvegarder')
                    ->setIcon('fas fa-save')
                    ->setCssClass('text-capitalize');
            })
            ->update('new', Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action
                    ->setLabel('Sauvegarder et Ajouter')
                    ->setIcon('fas fa-save')
                    ->setCssClass('text-capitalize');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Partenaire')->setColumns('col-md-6 col-xxl-5'),
            UrlField::new('link', 'Lien Vers Le Site')->setColumns('col-md-6 col-xxl-5'),
            ImageField::new('partnerImage', 'Logo du Partenaire')
                ->setColumns('col-md-6 col-xxl-5')
                ->setBasePath(self::UPLOAD_PARTNER_BASE_PATH)
                ->setUploadDir(self::UPLOAD_PARTNER_ROOT_PATH)
                ->setSortable(false)
                ->hideOnForm(),
            TextField::new('imageFile', 'Logo Du Partenaire')
                ->setFormType(VichImageType::class)
                ->hideOnIndex(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Partner) return;
        $entityInstance
            ->setAuthor($this->getUser())
            ->setCreatedAt(new \DateTimeImmutable());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Partner) return;
        $entityInstance
            ->setAuthor($this->getUser())
            ->setUpdatedAt(new \DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
    }
}
