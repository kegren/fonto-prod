<?php

namespace Demo\Controller;

use Fonto\Controller\Base;
use Demo\Model\Entity;
use Demo\Model\Form;
use Exception;

class Content extends Base
{
    /**
     * Base url
     *
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

    public function getIndexAction()
    {
        $em = $this->EntityManager();

        $data = array(
            'listAll' => $em->getRepository("Demo\Model\Entity\Content")->findAll(),
            'baseUrl' => $this->baseUrl,
            'session' => $this->session()
        );

        return $this->view()->render('content/index', $data);
    }

    public function getEditAction($id)
    {
        $em = $this->EntityManager();

        $data = array(
            'form' => $this->form(),
            'baseUrl' => $this->baseUrl,
            'session' => $this->session(),
            'create' => false,
            'editData' => $em->getRepository("Demo\Model\Entity\Content")->find($id)
        );

        return $this->view()->render('content/edit', $data);
    }

    public function postEditAction()
    {
        $request = $this->request();
        $contentId = $request->getParameter('contentId');

        if (!$this->auth()->isAuthenticated()) {
            return $this->response()->redirect("content/edit/$contentId");
        }

        if (!is_numeric($request->getParameter('contentId'))) {
            throw new Exception("Something went wrong.");
        }

        $session = $this->session();
        $validation = $this->validation();
        $rules = new Form\Content();
        $rules = $rules->rules();

        $validation->validate($rules, $request->getParameters());

        if ($validation->isValid()) {
            $em = $this->EntityManager();
            $user = $em->getRepository("Demo\Model\Entity\User")->findOneById($this->auth()->getAuthedId());

            $content = $em->getRepository("Demo\Model\Entity\Content")->findOneById($contentId);
            $content->editPopulate(
                array(
                    'user' => $user,
                    'type' => $request->getParameter('type'),
                    'title' => $request->getParameter('title'),
                    'slug' => $this->url()->urlSlug($request->getParameter('slug')),
                    'data' => $request->getParameter('data'),
                    'filter' => $request->getParameter('filter')
                )
            );
            $em->merge($content);
            $em->flush();

            $session->save('Success', 'Your content was successfully updated!');
            return $this->response()->redirect("content/edit/$contentId");
        } else {
            return $this->view()->render(
                "content/edit/$contentId",
                $this->commonInclude() + array('validation' => $validation, 'create' => false)
            );
        }
    }

    /**
     * Displays the view
     *
     * @return mixed
     */
    public function getNewAction()
    {
        return $this->view()->render('content/edit', $this->commonInclude() + array('create' => true));
    }

    public function postNewAction()
    {
        $session = $this->session();

        if (!$this->auth()->isAuthenticated()) {
            $session->save('Error', 'You need to be logged in before you can post');
            return $this->response()->redirect('content/new');
        }

        $request = $this->request();
        $formModel = new Form\Content();

        $validation = $this->validation();
        $validation->validate($formModel->rules(), $request->getParameters());

        if ($validation->isValid()) {
            $em = $this->EntityManager();

            $user = $em->getRepository("Demo\Model\Entity\User")->findOneById($this->auth()->getAuthedId());
            $content = new Entity\Content();
            $content->populate(
                array(
                    'user' => $user,
                    'type' => $request->getParameter('type'),
                    'title' => $request->getParameter('title'),
                    'slug' => $this->url()->urlSlug($request->getParameter('slug')),
                    'data' => $request->getParameter('data'),
                    'filter' => $request->getParameter('filter')
                )
            );

            $em->persist($content);
            $em->flush();

            $session->save('Success', 'Your content was successfully created');
            return $this->response()->redirect('content/new');
        } else {
            return $this->view()->render(
                'content/edit',
                $this->commonInclude() + array('validation' => $validation, 'create' => true)
            );
        }
    }

    private function commonInclude()
    {
        return array(
            'form' => $this->form(),
            'baseUrl' => $this->baseUrl,
            'session' => $this->session()
        );
    }
}