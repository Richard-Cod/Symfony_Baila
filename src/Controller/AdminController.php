<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Profil;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/profil/show", name="admin.profil.show")
     */
    public function showProfil(ProfilRepository $repo )
    {
       $profils= $repo->findAll();
        return $this->render('admin/show.html.twig', [
            'profils' => $profils,
        ]);
    }

   /**
     * @Route("/admin/profil/add", name="admin.profil.add")
     */
    public function addProfil( Request $request)
    {
         $profil=new Profil();
        
        $form = $this->createFormBuilder($profil)
            ->add('libelle', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();


            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                

                
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($profil);
                 $entityManager->flush();

                return $this->redirectToRoute('admin.profil.show');
            }
       
        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/profil/edit/{id}", name="admin.profil.edit")
     */
    public function editProfil($id,Request $request,ProfilRepository $repo)
    {
         $profil=$repo->find($id);
        
        $form = $this->createFormBuilder($profil)
            ->add('libelle', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();


            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                

                
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($profil);
                 $entityManager->flush();

                return $this->redirectToRoute('admin.profil.show');
            }
       
        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/profil/delete/{id}", name="admin.profil.delete")
     */
    public function deleteProfil($id,ProfilRepository $repo)
    {
        $profil=$repo->find($id);
        
         
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($profil);
        $entityManager->flush();
   

       return $this->redirectToRoute('admin.profil.show');
       
    }

     /**
     * @Route("/admin/caissier/show", name="admin.caissier.show")
     */
    public function showCaissier(UserRepository $repo,ProfilRepository $repoProf  )
    {
        $profil=$repoProf->findOneBy([
            'libelle'=>'Caissier'
        ]);
       $caissiers= $repo->findBy([
                 'profil'=>$profil
           ]
       );

        return $this->render('admin/caissier/show.html.twig', [
            'caissiers' => $caissiers,
        ]);
    }


   /**
     * @Route("/admin/caissier/add", name="admin.caissier.add")
     */
    public function addCaissier( Request $request)
    {
         $caissier=new User();
        
      
         $form = $this->createForm(UserType::class, $caissier);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($caissier);
                 $entityManager->flush();

                return $this->redirectToRoute('admin.caissier.show');
            }
       
        return $this->render('admin/caissier/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
