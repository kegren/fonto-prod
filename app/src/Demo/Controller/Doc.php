<?php

namespace Demo\Controller;

use Fonto\Controller\Base;
use Fonto\Documentation\Controller as Controllers;
use Fonto\Documentation\Model as Models;
use Fonto\Documentation\Package as Packages;
use Fonto\Documentation\Base as DocBase;

class Doc extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $controllers = new Controllers();
        $models = new Models();
        $packages = new Packages();

        return $this->view()->render(
            'doc/index',
            array(
                'session' => $this->session(),
                'baseUrl' => $this->url()->baseUrl(),
                'controllers' => $controllers->getAll(),
                'models' => $models->getAll(),
                'services' => $packages->getCoreServices(),
                'objects' => $packages->getCoreObjects()
            )
        );
    }

    public function viewAction($class)
    {
        $doc = new DocBase();
        $packages = new Packages();

        $classDoc = $doc->getPackageDocumentation($class);

        if (empty($classDoc)) {
            return false;
        }

        return $this->view()->render(
            'doc/view',
            array(
                'session' => $this->session(),
                'baseUrl' => $this->url()->baseUrl(),
                'services' => $packages->getCoreServices(),
                'objects' => $packages->getCoreObjects(),
                'classDoc' => $classDoc,
                'methodsDoc' => $doc->getPackageMethodsDocumentation()
            )
        );
    }
}