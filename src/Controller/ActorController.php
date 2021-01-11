<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
* @Route("/actors", name="actor_")
*/

class ActorController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        $actors = $this->getDoctrine()
             ->getRepository(Actor::class)
             ->findAll();

        return $this->render(
            'actor/index.html.twig',
            ['actors' => $actors]
        );
    }

    
    /**
     * @Route("/{slug}", requirements={"id"="\d+"}, methods={"GET"}, name="show")
     * @ParamConverter("actor", class="App\Entity\Actor", options={"mapping": {"slug": "slug"}})
     */
    public function show(Actor $actor): Response
    {
        $programs = $actor->getPrograms();

        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
            'programs' => $programs
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET","POST"})
     * @ParamConverter("actor", class="App\Entity\Actor", options={"mapping": {"slug": "slug"}})
     */
    public function edit(Request $request, Actor $actor): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Once the form is submitted, valid and the data inserted in database, you can define the success flash message
            $this->addFlash('success', 'The actor has been edited');
            return $this->redirectToRoute('actor_index');
        }

        return $this->render('actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form->createView(),
        ]);
    }

}
