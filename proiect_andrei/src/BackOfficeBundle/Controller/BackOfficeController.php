<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 01/02/19
 * Time: 23:01
 */

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackOfficeController extends Controller
{
    public function renderBackOfficeHomepageAction()
    {
        return $this->render('@BackOffice/backoffice_layout.html.twig');
    }
}