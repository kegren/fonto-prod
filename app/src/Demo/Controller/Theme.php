<?php

namespace Demo\Controller;

use Fonto\Controller\Base;

class Theme extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        return $this->view()->render(
            'theme/index',
            array(
                'baseUrl' => $this->url()->baseUrl(),
                'session' => $this->session(),
                'someDummyData' => $this->getDummyData(),
            )
        );
    }

    private function getDummyData()
    {
        $dummy = array('Some content', 'Another content box', 'More content', 'Demo box');
        return $dummy[array_rand($dummy)];
    }
}