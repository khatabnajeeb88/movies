<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MovieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }

     public function configureFields(string $pageName): iterable
     {
         return [
             IdField::new('id')->onlyOnIndex(),
             TextField::new('title'),
             IntegerField::new('releaseYear'),
             TextareaField::new('description'),
             ImageField::new('imagePath')
                 ->setUploadDir('public/images/uploads')
                 ->setBasePath('images/uploads')
                 ->setRequired(false)
         ];
     }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('releaseYear')
            ->add('id')
            ;
    }


    // public function configureActions(Actions $actions): Actions
    // {
    //     return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    // }
}
