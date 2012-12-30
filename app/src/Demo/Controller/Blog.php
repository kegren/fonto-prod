<?php

namespace Demo\Controller;

use Fonto\Controller\Base;
use Demo\Model\Entity;
use Demo\Model\Form;

class Blog extends Base
{
    /**
     * @var
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
     * Returns a view with all the data needed for the blog
     *
     * @return mixed
     */
    public function indexAction()
    {
        $em = $this->EntityManager();

        $data = array(
            'listAll' => $em->getRepository("Demo\Model\Entity\Content")->findBy(array('type' => 'post')),
            'baseUrl' => $this->baseUrl,
            'session' => $this->session()
        );

        return $this->view()->render('blog/index', $data);
    }
}