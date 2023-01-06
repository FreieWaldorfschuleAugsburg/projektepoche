<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper(['user', 'group']);

        $currentUser = getCurrentUser();
        if (!getCurrentUser() || !$currentUser->getGroup()->isAdmin()) {
            return redirect('login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Empty
    }
}