<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class EmployeeAdmin extends AbstractAdmin
{
    private UserPasswordHasherInterface $passwordHasher;

    public function setPasswordHasher(UserPasswordHasherInterface $passwordHasher): void
    {
        $this->passwordHasher = $passwordHasher;
    }

    
    public function getAccessMapping(): array
    {
        return [
            'list' => ['ROLE_EMPLOYEE_ADMIN', 'ROLE_ADMIN'],
            'create' => ['ROLE_EMPLOYEE_ADMIN', 'ROLE_ADMIN'],
            'edit' => ['ROLE_EMPLOYEE_ADMIN', 'ROLE_ADMIN'],
            'show' => ['ROLE_EMPLOYEE_ADMIN', 'ROLE_ADMIN'],
        ];
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues['_page'] = 1;
        $sortValues['_per_page'] = 3;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('delete');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name')
            ->add('mobile')
            ->add('department')
            ->add('active');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
            ->add('mobile')
            ->add('department')
            ->add('salary')
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
        $form
            ->add('name')
            ->add('email')
            ->add('password')
            ->add('mobile')
            ->add('department')
            ->add('salary')
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'Employee' => 'ROLE_EMPLOYEE',
                    'Employee Admin' => 'ROLE_EMPLOYEE_ADMIN',
                ],
            ])
            ->add('active');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('email')
            ->add('name')
            ->add('mobile')
            ->add('department')
            ->add('salary')
            ->add('active')
            ->add('created')
            ->add('updated');
    }

    public function prePersist(object $object): void
    {
        $user = new User();

        $user->setName($object->getName());
        $user->setEmail($object->getEmail());
        $user->setRoles($object->getRoles());
        $user->setActive($object->isActive());
        $user->setDeleted(false);

        if ($object->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $object->getPassword());
            $user->setPassword($hashedPassword);
        }

        $object->setUser($user);
    }

    public function preUpdate(object $object): void
    {
        $user = $object->getUser();

        if (!$user) {
            return;
        }

        $user->setName($object->getName());
        $user->setEmail($object->getEmail());
        $user->setRoles($object->getRoles());
        $user->setActive($object->isActive());

        if ($object->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $object->getPassword());
            $user->setPassword($hashedPassword);
        }
    }
}