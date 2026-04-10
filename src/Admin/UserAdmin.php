<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class UserAdmin extends AbstractAdmin
{
    
    public function getAccessMapping(): array
    {
        return [
            'list' => ['ROLE_SUPER_ADMIN'],
            'create' => ['ROLE_SUPER_ADMIN'],
            'edit' => ['ROLE_SUPER_ADMIN'],
            'delete' => ['ROLE_SUPER_ADMIN'],
            'show' => ['ROLE_SUPER_ADMIN'],
        ];
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues['_page'] = 1;
        $sortValues['_per_page'] = 5;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('delete');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('email')
            ->add('roles')
            ->add('name');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
            ->add('email')
            ->add('getAllRolesAsString')
            ->add('active')
            ->add('created')
            ->add('updated')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        if ($this->isCurrentRoute('edit')) {
            $form
                ->add('name')
                ->add('email')
                ->add('roles', ChoiceType::class, [
                    'multiple' => true,
                    'choices' => [
                        'Super Admin' => 'ROLE_SUPER_ADMIN',
                        'Admin' => 'ROLE_ADMIN',
                        'User' => 'ROLE_USER',
                        'Employee Admin' => 'ROLE_EMPLOYEE_ADMIN',
                        'Employee' => 'ROLE_EMPLOYEE',
                    ],
                ]);
        }

        if ($this->isCurrentRoute('create')) {
            $form
                ->add('name')
                ->add('email')
                ->add('password')
                ->add('roles', ChoiceType::class, [
                    'multiple' => true,
                    'choices' => [
                        'User' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN',
                        'Super Admin' => 'ROLE_SUPER_ADMIN',
                        'Employee' => 'ROLE_EMPLOYEE',
                    ],
                ]);
        }
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('email')
            ->add('roles')
            ->add('created')
            ->add('updated')
            ->add('name')
            ->add('active');
    }
}