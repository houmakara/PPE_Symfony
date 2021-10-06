<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Medecin;
use App\Entity\Sejour;
use App\Entity\Service;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="medecin")
     */
    public function index(): Response
    {
        return $this->render('medecin/index.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }

    /**
     * @Route("/AjouterMed", name="AjouterMed")
     */
    public function AjouterMed(Request $request){
        //formulaire
       $em=$this->getDoctrine()->getManager();
       $medecin=new Medecin();
       $form=$this->createFormBuilder($medecin)
                    ->add('nom',TextType::class,array('label'=>'Nom du médecin : '))
                    ->add('prenom',TextType::class,array('label'=>'Prenom : ')) 
                    ->add('service', EntityType::class, array('label'=>'Service : ',
                    'class'=>Service::class,
                    'choice_label'=>'libelle'))
                    ->add('save',SubmitType::class,array('label'=>'Enregistrement du médecin'))
                    -> getForm();
        // envoyer les données à la BDD
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $medecin=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($medecin);
            $em->flush();
            // return à la liste
            return $this->redirectToRoute('afficherMeds');
        }
        return $this->render('medecin/ajouterM.html.twig', array(
        'form'=> $form->createView()));
    }

    /**
     * @Route("/afficherMeds", name="afficherMeds")
     */
    public function afficherMeds(){
        $repository=$this->getDoctrine()->getRepository(Medecin::class);
        $lesMedecins=$repository->findAll();
        return $this->render('/medecin/afficherMeds.html.twig', [
            'medecins' => $lesMedecins,]);
    }

     /**
     * @Route("/ModifierMed/{id}", name="ModifierMed")
    */
    public function ModifierMed($id,Request $request){
        $repository=$this->getDoctrine()->getRepository(Medecin::class);
        $medecin=$repository->find($id);
        //formulaire
        $em=$this->getDoctrine()->getManager();
        $form=$this->createFormBuilder($medecin)
            ->add('nom',TextType::class,array('label'=>'Nom : '))
            ->add('prenom',TextType::class,array('label'=>'Prenom : ')) 
            ->add('service', EntityType::class, array('label'=>'Service : ',
                    'class'=>Service::class,
                    'choice_label'=>'libelle'))
            ->add('save',SubmitType::class,array('label'=>'Modifier le médecin'))
            -> getForm();
        // envoyer les données à la BDD
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $medecin=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($medecin);
            $em->flush();
            // return à la liste
            return $this->redirectToRoute('afficherMeds');
        }
        return $this->render('medecin/ModifierMed.html.twig',[
                            'form'=> $form->createView(),
                             'medecin'=>$medecin]);
     }

     /**
     * @Route("/supprimerMed/{id}", name="supprimerMed")
     */
    public function supprimerMed($id){
        $repository=$this->getDoctrine()->getRepository(Medecin::class);        
        $unMedecin=$repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($unMedecin);
        $em->flush();
        return $this->redirectToRoute('afficherMeds');
    }

    /**
     * @Route("/afficherMedById/{id}", name="afficherMedById")
     */
    public function afficherMedById($id,Request $request){
        $repository=$this->getDoctrine()->getRepository(Medecin::class);
        $unMedecin=$repository->find($id);
        return $this->render('/medecin/afficherMedById.html.twig', [
            'medecins' => $unMedecin,]);
    }


}
