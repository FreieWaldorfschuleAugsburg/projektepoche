<?php

namespace App\Controllers;

use function App\Helpers\getSlots;

class IndexController extends BaseController
{
    public function index(): string
    {
        if ($user = getCurrentUser()) {
            $templateFile = file_get_contents(VOTE_TEMPLATE_CONFIG);
            $template = json_decode($templateFile);
            return $this->render('vote/VoteView', ['user' => $user, 'slots' => getSlots(), 'template' => $template]);
        }

        return $this->render('LandingPageView');
    }
}