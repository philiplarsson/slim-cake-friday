<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class CookieController
{

    private $c;

    public function __construct(ContainerInterface $container)
    {
        $this->c = $container;
    }

    public function cookie(Request $request, Response $response)
    {
        $cookie = $this->getThisWeeksCookie();


        return $this->c->view->render($response, 'cookie.twig', [
            'cookie' => $cookie
        ]);
    }

    private function getThisWeeksCookie()
    {
        $d = new \DateTime('Friday');
        $fridayDate = $d->format('F j');

        $sql = "SELECT * FROM cookies WHERE date='{$fridayDate}'";
        $stmt = $this->c->db->query($sql);
        $cookie = $stmt->fetch();
        return $cookie;
    }
}
