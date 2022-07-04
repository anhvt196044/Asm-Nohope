<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/contact")]
class ContactController extends AbstractController
{
    #[Route("/", name: "contact_index")]  
    public function contactIndex(ManagerRegistry $managerRegistry) {
        $contacts = $managerRegistry->getRepository(Contact::class)->findAll();
        if ($contacts == null) {
            $this->addFlash("Error", "Something went wrong");
        }
        return $this->render(
            "contact/index.html.twig",
             [
                'contacts' => $contacts
             ]
        );
    }

    #[Route("/delete/{id}", name: "contact_delete")]
   public function contactDelete ($id, ManagerRegistry $managerRegistry) {
      $contact = $managerRegistry->getRepository(Contact::class)->find($id);
      if ($contact == null) {
         $this->addFlash("Error", "Contact not found !");
      }
      else {
         $manager = $managerRegistry->getManager();
         $manager->remove($contact);
         $manager->flush();
         $this->addFlash("Success", "Delete contact succeed !");
      }
      return $this->redirectToRoute("contact_index");
   }

   #[Route("/add", name: "contact_add")]
   public function addContact(Request $request) {
      $contact = new Contact;
      $form = $this->createForm(ContactType::class, $contact);
      $form->handleRequest($request);
      $title = "Add new contact";
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($contact);
         $manager->flush();
         $this->addFlash("Success","Add contact succeed !");
         return $this->redirectToRoute("contact_index");
      }
      return $this->renderForm("contact/add.html.twig",
      [
         'contactForm' => $form,
         'title' => $title
      ]);
   }

   #[Route("/edit/{id}", name: "contact_edit")]
   public function editcontact(Request $request, ManagerRegistry $managerRegistry, $id) {
      $contact = $managerRegistry->getRepository(Contact::class)->find($id);
      $form = $this->createForm(ContactType::class, $contact);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $managerRegistry->getManager();
         $manager->persist($contact);
         $manager->flush();
         $this->addFlash("Success","Edit contact succeed !");
         return $this->redirectToRoute("contact_index");
      }
      return $this->renderForm("contact/edit.html.twig",
      [
         'contactForm' => $form,
      ]);
   }
}