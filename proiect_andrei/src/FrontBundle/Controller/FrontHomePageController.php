<?php
/**
 * Created by PhpStorm.
 * Filename: FrontHomePageController.php.
 * User: Andrei Gache.
 * Website: https://andrei-gache.com
 * Date: 25/01/19
 * Time: 11:39
 */

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontHomePageController extends Controller
{
    public function renderHomepageAction()
    {
        return $this->render('@Front/Homepage/homepage.html.twig');
    }
}