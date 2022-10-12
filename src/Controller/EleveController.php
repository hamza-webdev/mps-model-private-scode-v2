<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Service\FileUploader;
use App\Repository\EleveRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/eleve')]
class EleveController extends AbstractController
{

    public function __construct(private FileUploader $fileUploader){}

    #[Route('/', name: 'app_eleve_index', methods: ['GET'])]
    public function index(EleveRepository $eleveRepository): Response
    {
        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);
    }


    /**
     * Create new Eleve
     * @param  \Symfony\Component\HttpFoundation\Request          $request
     * @param  \App\Repository\EleveRepository                    $eleveRepository
     * @param  \Symfony\Component\String\Slugger\SluggerInterface $slugger
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @author Hamza
     * @version 1.0
     */
    #[Route('/new', name: 'app_eleve_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EleveRepository $eleveRepository): Response
    {
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile  $photoFile */
            $photoFile = $form->get('photo')->getData();

            // this condition is needed because the 'photo' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photoFile) {
                $originalFilename = $this->fileUploader->upload($photoFile);


                // updates the 'photoFilename' property to store the PDF file name
                // instead of its contents
                $eleve->setPhoto($originalFilename);
            }

            $eleveRepository->save($eleve, true);

            return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    /**
     * Display un eleve Eleve
     * @param  Eleve $eleve
     * @return \Symfony\Component\HttpFoundation\Response
     * @author Hamza
     * @version 1.0
     */
    #[Route('/{id}', name: 'app_eleve_show', methods: ['GET'])]
    public function show(Eleve $eleve): Response
    {
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    /**
     * Edit One Eleve
     * @param  \Symfony\Component\HttpFoundation\Request          $request
     * @param  \App\Entity\Eleve                                  $eleve
     * @param  \Symfony\Component\String\Slugger\SluggerInterface $slugger
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @author Hamza
     * @version 1.0
     */
    #[Route('/{id}/edit', name: 'app_eleve_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eleve $eleve, EleveRepository $eleveRepository): Response
    {
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo')->getData();

            // this condition is needed because the 'photo' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photoFile) {
                $originalFilename = $this->fileUploader->upload($photoFile);

                // updates the 'photoFilename' property to store the PDF file name
                // instead of its contents
                $eleve->setPhoto($originalFilename);
            }

            $eleveRepository->save($eleve, true);

            return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleve/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    /**
     * Delete new Eleve
     * @param  \Symfony\Component\HttpFoundation\Request          $request
     * @param  \App\Repository\EleveRepository                    $eleveRepository
     * @param  \App\Entity\Eleve                                  $eleve
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @author Hamza
     * @version 1.0
     */
    #[Route('/{id}', name: 'app_eleve_delete', methods: ['POST'])]
    public function delete(Request $request, Eleve $eleve, EleveRepository $eleveRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->request->get('_token'))) {
            $eleveRepository->remove($eleve, true);
        }

        return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
    }
}
