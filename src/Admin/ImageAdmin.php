<?php

declare(strict_types=1);

namespace App\Admin;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ImageAdmin extends AbstractAdmin
{
     protected function configureDefaultSortValues(array &$sortValues): void
{
    $sortValues['_page'] = 1;
    $sortValues['_per_page'] = 4; // 👈 10 per page
}
    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollectionInterface $collection): void
{
    $collection->remove('delete');
}
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter

            ->add('filename')
            ->add('isMain')
            ->add('sorting');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('filename')
            ->add('isMain')
            ->add('sorting')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'edit' => [],
                    'show' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('file', FileType::class, [
                'required' => false
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name'
            ])
            ->add('isMain')
            ->add('sorting');
    }
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('filename')
            ->add('isMain')
            ->add('sorting');
    }


    public function prePersist(object $object): void
    {
        $this->uploadFile($object);
    }

    public function preUpdate(object $object): void
    {
        $this->uploadFile($object);
    }
    private function uploadFile($object): void
    {
        $file = $object->getFile();

        if ($file instanceof UploadedFile) {

            $fileName = uniqid() . '.' . $file->guessExtension();

            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/media';

            $file->move($uploadPath, $fileName);

            $object->setFileName($fileName);
        }
    }
}