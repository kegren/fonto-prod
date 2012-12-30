<?php

namespace Demo\Controller;

use Fonto\Controller\Base;
use Demo\Model\Entity;
use Demo\Model\Form;
use Exception;

class Page extends Base
{
    /**
     * Base url
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->baseUrl = $this->url()->baseUrl();
    }

    /**
     * @param  string $id
     * @return bool
     */
    public function viewAction($id)
    {
        $em = $this->EntityManager();
        $page = $em->getRepository("Demo\Model\Entity\Content")->findOneBy(array('slug' => $id));

        if (!$page) {
            return false;
        }

        $data = array(
            'page' => $page,
            'baseUrl' => $this->baseUrl,
            'session' => $this->session()
        );

        return $this->view()->render('page/index', $data);
    }
}