<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dinosaur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DinosaurController extends Controller
{
    /**
     * @Route("/", name="dinosaur_list")
     */
    public function indexAction($isMozilla)
    {
        $dinos = $this->getDoctrine()
            ->getRepository('AppBundle:Dinosaur')
            ->findAll();


/*        $request = new Request();
        $request->attributes->set(
            '_controller',
            'AppBundle:Dinosaur:_latestTweets'
        );
        $httpKernel = $this->container->get('http_kernel');
        $response = $httpKernel->handle(
            $request,
            HttpKernelInterface::SUB_REQUEST
        );*/


        return $this->render('dinosaurs/index.html.twig', [
            'dinos' => $dinos,
            'isMozilla' => $isMozilla,
        ]);
    }

    /**
     * @Route("/dinosaurs/{id}", name="dinosaur_show")
     */
    public function showAction($id)
    {
        $dino = $this->getDoctrine()
            ->getRepository('AppBundle:Dinosaur')
            ->find($id);

        if (!$dino) {
            throw $this->createNotFoundException('That dino is extinct!');
        }

        return $this->render('dinosaurs/show.html.twig', [
            'dino' => $dino,
        ]);
    }

    public function _latestTweetsAction($userOnMozilla)
    {
        $tweets = [
            'Dinosaurs can have existential crises too you know.',
            'Eating lollipops... ',
            'Rock climbing... '
        ];

        return $this->render('dinosaurs/_latestTweets.html.twig', [
            'tweets' => $tweets,
            'isMozilla' => $userOnMozilla,
        ]);
    }
} 