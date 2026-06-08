<?php

namespace App\Controller;

use App\Form\EntreprisePartenaireType;
use App\Entity\EntreprisePartenaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EntreprisePartenaireRepository;

class EntreprisePartenaireController extends AbstractController
{

    #[Route('/entreprisepartenaire', name: 'list')]
    public function index(): Response
    {
        $EntreprisePartenaire = $this->getDoctrine()->getManager()->getRepository(EntreprisePartenaire::class)->findAll();
        //$form = $this->createForm(EntreprisePartenaireType::class);
        return $this->render('entreprise_partenaire/index.html.twig', [
            'e'=>$EntreprisePartenaire

        ]);
    }
    /**
     * @Route("/addentreprisepartenaire", name="addEntreprisePartenaire")
     */
    public function addEntreprisePartenaire(Request $request): Response
    {
        $EntreprisePartenaire = new EntreprisePartenaire();
        $form = $this->createForm(EntreprisePartenaireType::class, $EntreprisePartenaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($EntreprisePartenaire); //Add
            $em->flush();

            return $this->redirectToRoute('list');
        }
        return $this->render('entreprise_partenaire/createEntreprisePartenaire.html.twig', ['f' => $form->createView()]);
    }

    #[Route('/removeEntreprisePartenaire/{id}', name: 'supentreprisepartenaire')]
    public function suppressionEntreprisePartenaire(EntreprisePartenaire $EntreprisePartenaire): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($EntreprisePartenaire);
        $em->flush();


        //return$this->redirectToRoute('supentreprisepartenaire');
        return $this->redirectToRoute('list', ['id' => $EntreprisePartenaire->getId()]);
    }

    #[Route('/modifentreprisepartenaire/{id}', name: 'modifEntreprisePartenaire')]
    public function modifEntreprisePartenaire(Request $request, $id): Response
    {
        $EntreprisePartenaire = $this->getDoctrine()->getManager()->getRepository(EntreprisePartenaire::class)->find($id);
        $form = $this->createForm(EntreprisePartenaireType::class, $EntreprisePartenaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('list');
        }
        return $this->render('entreprise_partenaire/updateEntreprisePartenaire.html.twig', ['f' => $form->createView()]);
    }

}