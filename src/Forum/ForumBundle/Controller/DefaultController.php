<?php

namespace Forum\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ForumForumBundle:Default:layout.html.twig');
    }
}
