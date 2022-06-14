<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\UploadPhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(UploadPhotoType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($this->getUser()){
                $em = $this->getDoctrine()->getManager();
                $entityPhoto = new Photo();
                $entityPhoto->setFilename($form->get('filename')->getData());
                $entityPhoto->setIsPublic($form->get('is_public')->getData());
                $entityPhoto->setUploadedAt(new \DateTimeImmutable());
                $entityPhoto->setUser($this->getUser());

                $em->persist($entityPhoto);
                $em->flush();
            }
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
