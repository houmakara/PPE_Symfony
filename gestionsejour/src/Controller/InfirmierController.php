<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use App\Entity\Service;
use App\Entity\Sejour;
use App\Entity\User;
use App\Entity\Chambre;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InfirmierController extends AbstractController
{
    /**
     * @Route("/infirmier", name="infirmier")
     */
    public function index(): Response
    {
        return $this->render('infimier/index.html.twig', [
            'controller_name' => 'InfimierController',
        ]);
    }
     /**
     * @Route("/SortieSej/{id}", name="SortieSej")
     */
    public function SortieSejour($id, Request $request){
        $repository=$this->getDoctrine()->getRepository(Sejour::class);
        $sortie=$repository->find($id);
        //formulaire
        $em=$this->getDoctrine()->getManager();
        $form=$this->createFormBuilder($sortie)
                    // Ajout date/heure depart 
                    ->add('dateDepart',BirthdayType::class,array('label'=>"Date de depart : "))
                    ->add('heureDepart',TextType::class,array('label'=>"Heure de départ : "  ))
                    ->add('save',SubmitType::class,array('label'=>'Valider la sortie'))
                   -> getForm();
       // envoyer les données à la BDD
       $form->handleRequest($request);
       if($form->isSubmitted()&& $form->isValid()){
           $sortie=$form->getData();
           $em=$this->getDoctrine()->getManager();
           $em->persist($sortie);
           $em->flush();
           // return à la liste
           return $this->redirectToRoute('InfoSejourinfirmier');
       }
       return $this->render('infirmier/SortirSejour.html.twig', array(
       'form'=> $form->createView(), 'sejour'=>$sortie));
    }
    /**
     * @Route("/InfoSejourinfirmier", name="InfoSejourinfirmier")
     */
    public function AfficherSejourServiceInfirmier(){
        $repository=$this->getDoctrine()->getRepository(Sejour::class);
        $lesSejours=$repository->findByService($this->getUser()->getService());
        return $this->render('infirmier/ValiderSejourInfimier.html.twig', [
            'sejours' => $lesSejours,]);
    }

}
