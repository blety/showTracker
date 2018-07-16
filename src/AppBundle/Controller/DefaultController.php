<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Band;
use AppBundle\Entity\User;
use AppBundle\Form\BandType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();
        }

        // Un id bidon
        $id = 123;
        // On stock notre repository dans une variable pour pouvoir y accéder plus facilement
        $userRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');

        // Retourne un tableau d'objets de type Utilisateur
        $userArray = $userRepository->findBy(array('lastName' => 'Dupont'));
        // Retourne un objet de type Utilisateur
        $userObject = $userRepository->findOneBy(array('firstName' => 'Anne-Sophie'));
        // On ne s'en sert pas, fonction raccourci de findBy(array('id' => ...))
        $userRepository->find($id);

        $allUsers = $userRepository->findAll();

        $band = new Band();
        $bandForm = $this->createForm( BandType::class, $band);

        $bandForm->handleRequest($request);

        if ($bandForm->isSubmitted() && $bandForm->isValid()) {

            $em->persist($band);
            $em->flush();
        }

        $bandRepository = $this->getDoctrine() ->getManager() ->getRepository('AppBundle:Band');
        $allBands = $bandRepository->findAll();


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'users' => $allUsers,
            'userForm' => $form->createView(),
            'bands' => $allBands,
            'bandForm' => $bandForm->createView()

        ));
    }
}
