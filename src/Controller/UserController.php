<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $page  = max(1, (int) $request->query->get('page', 1));
        $limit = 2;


        $sortBy  = $request->query->get('sortBy', 'name');
        $sortDir = strtoupper($request->query->get('sortDir', 'ASC'));

        if (!in_array($sortBy, ['name', 'email'])) {
            $sortBy = 'name';
        }

        if (!in_array($sortDir, ['ASC', 'DESC'])) {
            $sortDir = 'ASC';
        }

        $users = $userRepository->getPaginatedUsers(
            $page,
            $limit,
            $sortBy,
            $sortDir
        );

        $totalUsers = $userRepository->getTotalUsers();
        $totalPages = (int) ceil($totalUsers / $limit);

        return $this->render('user/index.html.twig', [
            'users'      => $users,
            'page'       => $page,
            'totalPages' => $totalPages,
            'sortBy'     => $sortBy,
            'sortDir'    => $sortDir,
        ]);
    }

    // new and edit 
    #[Route('/user/new', name: 'user_new')]
    #[Route('/user/{id}/edit', name: 'user_edit')]
    public function form(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        User|null $user = null
    ): Response {
        $isNew = false;

        //  NEW USER
        if (!$user) {
            $isNew = true;
            $user = new User();
            $user->setActive(true);
            $user->setRoles(['ROLE_USER']);

            //  DEFAULT PASSWORD 
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                '123456'
            );
            $user->setPassword($hashedPassword);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                $isNew ? 'User created successfully' : 'User updated successfully'
            );

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/form.html.twig', [
            'form'   => $form->createView(),
            'isEdit' => !$isNew,
        ]);
    }

    #[Route('/user/{id}/delete', name: 'user_delete')]
    public function delete(User $user, EntityManagerInterface $em): Response
    {
        // soft delete: sirf inactive
        //$user->setActive(true);
        $user->setDeleted(true);
        $em->flush();

        $this->addFlash('success', 'User deleted (soft delete)');
        return $this->redirectToRoute('app_user');
    }


    /// active click then inactive .
    #[Route('/user/{id}/toggle-active', name: 'user_toggle_active')]
    public function toggleActive(User $user, EntityManagerInterface $em): Response
    {
        // toggle: active → inactive OR inactive → active
        $user->setActive(!$user->isActive());
        $em->flush();

        $this->addFlash(
            'success',
            $user->isActive() ? 'User activated' : 'User deactivated'
        );

        return $this->redirectToRoute('app_user');
    }
}
