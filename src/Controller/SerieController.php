<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/serie")
 */
class SerieController extends AbstractController
{
    /**
     * @Route("/", name="series")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $serie = new Serie();
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $fichier = $form->get('afficheUpload')->getData();
            $nomFichier = uniqid().'.'.$fichier->guessExtension();

            try{
                $fichier->move(
                    $this->getParameter('upload_dir'),
                    $nomFichier
                );
            }
            catch(FileException $e){
                $this->addFlash('danger', 'Impossible de déplacer le fichier');
                echo 'Impossible de déplacer le fichier';
            }

            $serie->setAffiche($nomFichier);

            $em->persist($serie);
            $em->flush();

            $this->addFlash('success', 'Série ajoutée');
        }

        $series = $em->getRepository(Serie::class)->findAll();

        return $this->render('serie/index.html.twig', [
            'series'        => $series,
            'ajout_serie'   => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="serie_edit")
     */
    public function edit(Request $request, Serie $serie=null){

        if($serie != null){
            
            $form = $this->createForm(SerieType::class, $serie);

            $affiche = $serie->getAffiche();

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();

                $fichier = $form->get('afficheUpload')->getData();

                if($fichier){
                    if($affiche != null){
                        unlink($this->getParameter('upload_dir').$affiche);
                    }

                    $nomFichier = uniqid().'.'.$fichier->guessExtension();

                    try{
                        $fichier->move(
                            $this->getParameter('upload_dir'),
                            $nomFichier
                        );
                    }
                    catch(FileException $e){
                        $this->addFlash('danger', 'Impossible de déplacer le fichier');
                        echo 'Impossible de déplacer le fichier';
                    }

                    $serie->setAffiche($nomFichier);
                }

                $em->persist($serie);
                $em->flush();

                $this->addFlash('success', "Série mise à jour");
            }

            return $this->render('serie/edit.html.twig', [
                'serie' => $serie,
                'serie_edit' => $form->createView()
            ]);

        }
        else{
            $this->addFlash('danger', "Serie introuvable");
            return $this->redirectToRoute('series');
        }

    }

    /**
     * @Route("/delete/{id}", name="serie_delete")
     */
    public function delete(Serie $serie=null){

        if($serie != null){
            $em = $this->getDoctrine()->getManager();
            $em->remove($serie);
            $em->flush();

            $this->addFlash('warning', "Série supprimée");
        }   
        else{
            $this->addFlash('danger', 'Série introuvable');
        }

        return $this->redirectToRoute('series');

    }
}
