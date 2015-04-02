<?php

namespace Kl3sk\ChosenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('Kl3skChosenBundle:Default:index.html.twig', array('name' => $name));
    }
}
