<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 01/02/19
 * Time: 23:01
 */

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BackOfficeController extends Controller
{
    public function renderBackOfficeHomepageAction()
    {
        return $this->render('@BackOffice/BackOfficeHomepage/backoffice_homepage.html.twig');
    }

    public function renderCreateClientPageAction()
    {
        return $this->render('@BackOffice/Client/create_client_backoffice.html.twig');
    }

    public function renderCreateClientPostAction()
    {

        return new Response(Response::HTTP_BAD_GATEWAY);
    }
}