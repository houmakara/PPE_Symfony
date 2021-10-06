<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use App\Entity\Service;
use App\Entity\Sejour;
use App\Entity\Chambre;
use App\Entity\Medecin;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SejourController extends AbstractController
{
    /**
     * @Route("/sejour", name="sejour")
     */
    public function index(): Response
    {
        return $this->render('sejour/index.html.twig', [
            'controller_name' => 'SejourController',
        ]);
    }

    /**
     * @Route("/afficherSej", name="afficherSej")
     */
    public function AfficherAll(){
        $repository=$this->getDoctrine()->getRepository(Sejour::class);
        $lesSejours=$repository->findAll();
        return $this->render('sejour/afficherSejour.html.twig', [
            'sejours' => $lesSejours,]);
    }


    /**
     * @Route("/CreateSejour", name="CreateSejour")
     */
    public function CreateSejour(Request $request){
         //formulaire
       $em=$this->getDoctrine()->getManager();
       $sejour=new Sejour();
       $form=$this->createFormBuilder($sejour)
                    ->add('dateArrivee',BirthdayType::class,array('label'=>"Date d'arrivée : "))
                    ->add('heureArrivee',TextType::class,array('label'=>"Heure d'arrivée : "  ))
                    ->add('patient', EntityType::class, array('label'=>'Patient : ',
                            'class'=>Patient::class,
                            'choice_label'=>'info'))
                    ->add('chambre', EntityType::class, array('label'=>'id chambre/lit : ',
                            'class'=>Chambre::class,
                            'choice_label'=>'id'))
                    ->add('service', EntityType::class, array('label'=>'Service : ',
                            'class'=>Service::class,
                            'choice_label'=>'libelle'))
                    ->add('medecin', EntityType::class, array('label'=>'Medecin : ',
                            'class'=>Medecin::class,
                            'choice_label'=>'info'))
                    ->add('save',SubmitType::class,array('label'=>'Enregistrement du séjour'))
                    -> getForm();
        // envoyer les données à la BDD
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $sejour=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($sejour);
            $em->flush();
            // return à la liste
            return $this->redirectToRoute('afficherSej');
        }
        return $this->render('sejour/ajoutSejour.html.twig', array(
        'form'=> $form->createView()));

    }

   /**
     * @Route("/suppSejour/{id}", name="suppSejour")
     */
    public function supprimer($id){
        $repository=$this->getDoctrine()->getRepository(Sejour::class);        
        $unsejour=$repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($unsejour);
        $em->flush();
        return $this->redirectToRoute('afficherSej');
    }

    /**
     * @Route("/ModifSejour/{id}", name="ModifSejour")
     */
    public function ModifSejour($id, Request $request){
        $repository=$this->getDoctrine()->getRepository(Sejour::class);
        $sejour=$repository->find($id);
        //formulaire
      $em=$this->getDoctrine()->getManager();
      $form=$this->createFormBuilder($sejour)
                    ->add('dateArrivee',BirthdayType::class,array('label'=>"Date d'arrivée : "))
                    ->add('heureArrivee',TextType::class,array('label'=>"Heure d'arrivée : "  ))
                    ->add('patient', EntityType::class, array('label'=>'Patient : ',
                           'class'=>Patient::class,
                           'choice_label'=>'info'))
                    ->add('chambre', EntityType::class, array('label'=>'id chambre/lit : ',
                            'class'=>Chambre::class,
                            'choice_label'=>'id'))
                    ->add('service', EntityType::class, array('label'=>'Service : ',
                           'class'=>Service::class,
                           'choice_label'=>'libelle'))
                    ->add('medecin', EntityType::class, array('label'=>'Medecin : ',
                           'class'=>Medecin::class,
                           'choice_label'=>'info'))
                    ->add('save',SubmitType::class,array('label'=>'Modfier patient'))
                   -> getForm();
       // envoyer les données à la BDD
       $form->handleRequest($request);
       if($form->isSubmitted()&& $form->isValid()){
           $sejour=$form->getData();
           $em=$this->getDoctrine()->getManager();
           $em->persist($sejour);
           $em->flush();
           // return à la liste
           return $this->redirectToRoute('afficherSej');
       }
       return $this->render('sejour/ModifSejour.html.twig', array(
       'form'=> $form->createView(), 'sejour'=>$sejour));
       }
}