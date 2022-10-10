<?php

namespace App\Controller;

use App\Entity\Guardian;
use App\Form\Guardian1Type;
use App\Repository\GuardianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/guardian')]
class GuardianController extends AbstractController
{
    #[Route('/', name: 'app_guardian_index', methods: ['GET'])]
    public function index(GuardianRepository $guardianRepository): Response
    {
        return $this->render('guardian/index.html.twig', [
            'guardians' => $guardianRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_guardian_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GuardianRepository $guardianRepository): Response
    {
        $guardian = new Guardian();
        $form = $this->createForm(Guardian1Type::class, $guardian);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guardianRepository->save($guardian, true);

            return $this->redirectToRoute('app_guardian_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guardian/new.html.twig', [
            'guardian' => $guardian,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guardian_show', methods: ['GET'])]
    public function show(Guardian $guardian): Response
    {
        return $this->render('guardian/show.html.twig', [
            'guardian' => $guardian,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_guardian_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guardian $guardian, GuardianRepository $guardianRepository): Response
    {
        $form = $this->createForm(Guardian1Type::class, $guardian);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guardianRepository->save($guardian, true);

            return $this->redirectToRoute('app_guardian_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guardian/edit.html.twig', [
            'guardian' => $guardian,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guardian_delete', methods: ['POST'])]
    public function delete(Request $request, Guardian $guardian, GuardianRepository $guardianRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guardian->getId(), $request->request->get('_token'))) {
            $guardianRepository->remove($guardian, true);
        }

        return $this->redirectToRoute('app_guardian_index', [], Response::HTTP_SEE_OTHER);
    }
}
