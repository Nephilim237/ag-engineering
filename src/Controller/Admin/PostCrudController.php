<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostCrudController extends AbstractCrudController
{
    public const UPLOAD_POST_BASE_PATH = 'uploads/images/posts';
    public const UPLOAD_POST_ROOT_PATH = 'public/uploads/images/posts';

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index', 'Liste des Posts')
            ->setPageTitle('new', 'Publier Un Nouveau Post')
            ->setPaginatorPageSize(50)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->update('index', 'new', function (Action $action) {
                return $action
                    ->setLabel('Nouveau Post')
                    ->setIcon('fas fa-rss-square')
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
            TextField::new('title', 'Titre'),
            TextField::new('slug', 'Slug')->onlyOnIndex(),
            AssociationField::new('category', 'Catégorie Associée'),
            TextEditorField::new('content')->setFormType(CKEditorType::class)->hideOnIndex(),
            TextField::new('imageFile', 'Illustration')
                ->hideOnIndex()
                ->setFormType(VichImageType::class)->setColumns('col-sm-12 col-md-3'),
            ImageField::new('postImage', 'Illustration')
                ->hideOnForm()
                ->setBasePath(self::UPLOAD_POST_BASE_PATH)
                ->setUploadDir(self::UPLOAD_POST_ROOT_PATH)
                ->setSortable(false),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Post) return;
        $entityInstance
            ->setAuthor($this->getUser())
            ->setCreatedAt(new \DateTimeImmutable());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Post) return;
        $entityInstance
            ->setAuthor($this->getUser())
            ->setUpdatedAt(new \DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }
}
