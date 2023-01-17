<?php

namespace App\Filters;

use CodeIgniter\Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('credential');
        $authenticationHeader = $request->getServer('HTTP_X_API_KEY');

        try {
            validateApiKey($authenticationHeader);
            return $request;
        } catch (\Exception $exception) {
            return Services::response()->setJSON(['error' => $exception->getMessage()])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Empty
    }
}