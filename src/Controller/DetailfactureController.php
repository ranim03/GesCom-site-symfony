<?php

namespace App\Controller;

use App\Entity\Detailfacture;
use App\Form\DetailfactureType;
use App\Repository\DetailfactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/detailfacture')]
final class DetailfactureController extends AbstractController
{
    #[Route(name: 'app_detailfacture_index', methods: ['GET'])]
    public function index(DetailfactureRepository $detailfactureRepository): Response
    {
        return $this->render('detailfacture/index.html.twig', [
            'detailfactures' => $detailfactureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_detailfacture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $detailfacture = new Detailfacture();
        $form = $this->createForm(DetailfactureType::class, $detailfacture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($detailfacture);
            $entityManager->flush();

            return $this->redirectToRoute('app_detailfacture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detailfacture/new.html.twig', [
            'detailfacture' => $detailfacture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detailfacture_show', methods: ['GET'])]
    public function show(Detailfacture $detailfacture): Response
    {
        return $this->render('detailfacture/show.html.twig', [
            'detailfacture' => $detailfacture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detailfacture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Detailfacture $detailfacture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DetailfactureType::class, $detailfacture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_detailfacture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detailfacture/edit.html.twig', [
            'detailfacture' => $detailfacture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detailfacture_delete', methods: ['POST'])]
    public function delete(Request $request, Detailfacture $detailfacture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailfacture->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($detailfacture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_detailfacture_index', [], Response::HTTP_SEE_OTHER);
    }
}
