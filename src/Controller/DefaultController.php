<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

/**
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("", name="default")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(DocumentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('view', [
                'id' => $form->getData()->getId(),
            ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/view/{id}", name="view")
     */
    public function view(Document $document)
    {
        return $this->render('default/view.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/download/{id}", name="download")
     */
    public function download(Document $document, DownloadHandler $downloadHandler)
    {
        return $downloadHandler->downloadObject($document, 'file');
    }
}
