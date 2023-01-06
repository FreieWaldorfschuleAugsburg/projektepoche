<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoggedInFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper(['user', 'group']);

        $currentUser = getCurrentUser();
        if (is_null($currentUser)) {
            return redirect('login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Empty
    }
}