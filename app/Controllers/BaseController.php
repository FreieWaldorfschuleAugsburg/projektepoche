<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;


    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['db', 'slot', 'project', 'user', 'group', 'vote', 'file', 'settings', 'form'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function render($name, $data = null, $renderNavbar = true, $renderMain = true, $fullFooter = true): string
    {
        $renderedContent = view('components/header');

        if ($renderNavbar) {
            $renderedContent .= view('components/navbar');
        }

        if ($renderMain) {
            $renderedContent .= view('components/main');
        }

        if (!is_null($data)) {
            $renderedContent .= view($name, $data);
        } else {
            $renderedContent .= view($name);
        }

        if ($renderMain) {
            $renderedContent .= view('components/main_end');
        }

        if ($fullFooter) {
            $renderedContent .= view('components/footer');
        } else {
            $renderedContent .= view('components/footer_short');
        }

        return $renderedContent;
    }
}
