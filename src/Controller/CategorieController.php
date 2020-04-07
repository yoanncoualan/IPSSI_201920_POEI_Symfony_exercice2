<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Serie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();

        $series = $em->getRepository(Serie::class)->findAll();

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', $translator->trans('categorie.added'));
        }

        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/index.html.twig', [
            'series'        => $series,
            'categories'    => $categories,
            'ajout_categorie'=> $form->createView()
        ]);
    }

    /**
     * @Route("/categorie/edit/{id}", name="categorie_edit")
     */
    public function edit(Request $request, Categorie $categorie=null){

        if($categorie != null){
            // Il a trouvé la catégorie demandée

            $form = $this->createForm(CategorieType::class, $categorie);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $pdo = $this->getDoctrine()->getManager();
                $pdo->persist($categorie);  // prepare en PDO
                $pdo->flush();              // execute en PDO

                $this->addFlash('success', 'Catégorie mise à jour');
            }

            return $this->render('categorie/edit.html.twig', [
                'categorie'         => $categorie,
                'edit_categorie'    => $form->createView()
            ]);
        }
        else{
            // Il n'a pas trouvé la catégorie demandée

            $this->addFlash('danger', 'Catégorie introuvable');
            return $this->redirectToRoute('home');
        }

    }

    /**
     * @Route("/categorie/delete/{id}", name="categorie_delete")
     */
    public function delete(Categorie $categorie=null){

        if($categorie != null){

            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();

            $this->addFlash('warning', 'Catégorie supprimée');

        }
        else{
            $this->addFlash('danger', 'Catégorie introuvable');
        }

        return $this->redirectToRoute('home');
    }
}
