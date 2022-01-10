<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{


    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }
    //Partie 2-1 : afficher les livres ayant un prix = 200
    /**
     * @Route("/livreprix", name="livre_prix")
     */
    public function livrePrix(): Response
    {
        $em= $this ->getDoctrine() -> getManager();
        $repLivre = $em -> getRepository(Livre::class);
        $lesLivres = $repLivre -> findBy(['prix'=> 200]);
        return $this->render('livre/index.html.twig', [
            'livres' => $lesLivres,
        ]);
    }

    //Partie 2-2 : afficher les livres dont le le prix est récupérable à partir de la route.
    /**
     * @Route("/livreprix/{prix}", name="livre_prix")
     */
    public function livrePrix2(float $prix =-1 ): Response
    {
        if($prix ==-1){
            return $this->redirectToRoute("livre_index");
        }
        else{
        $em= $this ->getDoctrine() -> getManager();
        $repLivre = $em -> getRepository(Livre::class);
        $lesLivres = $repLivre -> findBy(['prix'=> $prix]);
        return $this->render('livre/index.html.twig', [
            'livres' => $lesLivres,
        ]);
        }
    }

    //Partie 2-3 : récupérer les livres dont le prix est supérieur à $x.
    // Le code de cette méthode doit utiliser un constructeur de requête DQL.

    /**
     * @Route("/livreprix3/{prix}", name="livre_prix3")
     */

    public function rechercheParPrixSuperieur(float $prix=-1)
    {
        if($prix ==-1){
            return $this->redirectToRoute("livre_index");
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $repLivre = $em->getRepository(Livre::class);
            $lesLivres = $repLivre->rechercheParPrixSuperieur($prix);

            return $this->render('livre/index.html.twig', [
                'livres' => $lesLivres,
            ]);
        }
    }

    /**
     * @Route("/new", name="livre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }


}
