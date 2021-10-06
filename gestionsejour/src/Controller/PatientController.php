<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use App\Entity\Sejour;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    /**
     * @Route("/afficherPatient", name="afficherPatient")
     */
    public function AfficherAll(){
        $repository=$this->getDoctrine()->getRepository(Patient::class);
        $lesPatients=$repository->findAll();
        return $this->render('/patient/afficherPatient.html.twig', [
            'patients' => $lesPatients,]);
    }

     /**
     * @Route("/Ajoutpatient", name="Ajoutpatient")
     */
    public function formulaire(Request $request){
        //formulaire
       $em=$this->getDoctrine()->getManager();
       $patient=new Patient();
       $form=$this->createFormBuilder($patient)
                    ->add('nom',TextType::class,array('label'=>'Nom du patient : '))
                    ->add('prenom',TextType::class,array('label'=>'Prenom : ')) 
                    ->add('datedenaissance',BirthdayType::class,array('label'=>'Date de naissance : '))
                    ->add('adresse',TextType::class,array('label'=>'Adresse : '))
                    ->add('ville',TextType::class,array('label'=>'Ville : '))
                    ->add('telephone',TextType::class,array('label'=>'Téléphone : '))
                    ->add('sexe', ChoiceType::class, array('label'=>'Sexe : ',
                            'choices'  => array(
                            'sexe' => null,
                            'Masculin'=>'Masculin',
                            'Feminin'=>'Feminin',)))
                    ->add('save',SubmitType::class,array('label'=>'Enregistrement du patient'))
                    -> getForm();
        // envoyer les données à la BDD
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $patient=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();
            // return à la liste
            return $this->redirectToRoute('afficherPatient');
        }
        return $this->render('patient/ajoutP.html.twig', array(
        'form'=> $form->createView()));

    }

    /**
     * @Route("/supprimer/{id}", name="supprimerPat")
     */
    public function supprimer($id){
        $repository=$this->getDoctrine()->getRepository(Patient::class);        
        $unPatient=$repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($unPatient);
        $em->flush();
        return $this->redirectToRoute('afficherPatient');
    }

    /**
     * @Route("/patientmodif/{id}", name="patientmodif")
    */
    public function modifier($id,Request $request){
        $repository=$this->getDoctrine()->getRepository(Patient::class);
        $patient=$repository->find($id);
        //formulaire
        $em=$this->getDoctrine()->getManager();
        $form=$this->createFormBuilder($patient)
            ->add('nom',TextType::class,array('label'=>'Nom du patient : '))
            ->add('prenom',TextType::class,array('label'=>'Prenom : ')) 
            ->add('datedenaissance',BirthdayType::class,array('label'=>'Date de naissance : '))
            ->add('adresse',TextType::class,array('label'=>'Adresse : '))
            ->add('ville',TextType::class,array('label'=>'Ville : '))
            ->add('telephone',TextType::class,array('label'=>'Téléphone : '))
            ->add('sexe', ChoiceType::class, array('label'=>'Sexe : ',
                'choices'  => array(
                    'sexe' => null,
                    'Masculin'=>'Masculin',
                    'Feminin'=>'Feminin',
                )))
            ->add('save',SubmitType::class,array('label'=>'Modifier le patient'))
            -> getForm();
        // envoyer les données à la BDD
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $patient=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();
            // return à la liste
            return $this->redirectToRoute('afficherPatient');
        }
        return $this->render('patient/ModifP.html.twig',[
                            'form'=> $form->createView(),
                             'patient'=>$patient]);
     }

    /**
    * @Route("/patientchambre", name="patientchambresejour")
    */
    public function ChambrePatient(){
        $repository=$this->getDoctrine()->getRepository(Sejour::class);
        $ChambrePatient=$repository->findAll();
        return $this->render('patient/afficherChambrePatient.html.twig', [
            'chambrepatients' => $ChambrePatient,]);
    }
}