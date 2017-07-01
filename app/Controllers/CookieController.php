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

    public function getWeekCookie(Request $request, Response $response, $args)
    {
        $week = $args['week'];

        if (!$this->correctInput($week)) {
            return $response->withJson([
                'errors' => array([
                    'status' => 400,
                    'title' => 'Invalid week',
                    'detail' => "'{$week}' is not a valid week. Week needs to be a number between 1 and 55.",
                ])
            ], 400);
        }
        $cookie = $this->getCookieFor($week);
        if ($cookie) {
            $jsonData = [
                'data' => [
                    'type' => 'cookies',
                    'id' => $cookie['id'],
                    'attributes' => [
                        'date' => $cookie['date'],
                        'name' => $cookie['name'],
                        'image' => $cookie['image']
                    ]
                ]
            ];
        } else {
            $jsonData = [
                'data' => []
            ];
        }

        return $response->withJson($jsonData);
    }

    private function correctInput($week)
    {
        if (is_numeric($week) && $week > 1 && $week < 55) {
            return true;
        }
        return false;
    }

    private function getCookieFor($week)
    {
        $d = new \DateTime();
        $year = $d->format('Y');

        $d->setISODate($year, $week);
        $d->modify("+4 day");
        $fridayDate = $d->format('F j');

        $sql = "SELECT * FROM cookies WHERE date='{$fridayDate}'";
        $stmt = $this->c->db->query($sql);
        $cookie = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $cookie;
    }

    private function getThisWeeksCookie()
    {
        $d = new \DateTime();
        $week = $d->format('W');
        return $this->getCookieFor($week);
    }
}
