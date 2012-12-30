<?php
/**
 * Home controller
 */

namespace Demo\Controller;

use Fonto\Controller\Base;
use Fonto\Documentation\Controller as Controllers;

class Home extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $controllers = new Controllers();

        $data = array(
            'title' => 'Fonto PHP Framework',
            'text' => 'Under development',
            'baseUrl' => $this->url()->baseUrl(),
            'controllers' => $controllers->getAll(),
        );

        return $this->view()->render('home/index', $data);
    }

    public function installAction()
    {
        $em = $this->EntityManager();

        $defaultPwd = $this->hash()->hashPassword('admin');

        $em->createQueryBuilder();

        $sql = <<<EOD
            CREATE TABLE IF NOT EXISTS users
            (
                id int NOT NULL AUTO_INCREMENT,
                username varchar(40),
                password varchar(60),
                email varchar(60),
                name varchar(80),
                PRIMARY KEY (id)
            );
            CREATE TABLE IF NOT EXISTS content
            (
                id int NOT NULL AUTO_INCREMENT,
                user_id int,
                type varchar(30),
                title varchar(150),
                slug varchar(120),
                data text,
                filter varchar(120),
                created datetime,
                updated datetime NULL,
                deleted datetime NULL,
                PRIMARY KEY (id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            );
            CREATE TABLE IF NOT EXISTS roles
            (
                id int NOT NULL AUTO_INCREMENT,
                name varchar(40),
                description varchar(100),
                PRIMARY KEY (id)
            );
            CREATE TABLE IF NOT EXISTS userroles
            (
                id int NOT NULL AUTO_INCREMENT,
                user_id int,
                role_id int,
                PRIMARY KEY (id),
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (role_id) REFERENCES roles(id)
            );
            CREATE TABLE IF NOT EXISTS guestbook
            (
                id int NOT NULL AUTO_INCREMENT,
                title varchar(100),
                post text,
                user varchar(40),
                date timestamp DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            );

            INSERT INTO users (username, password, email, name) VALUES ('admin', '$defaultPwd', 'admin@email.se', 'Adminssion');
            INSERT INTO content (user_id, type, title, slug, data, filter, created, updated, deleted)
            VALUES (1, "post", "Hello World","hello-world", "Hello world post!", "bbcode", now(), now(), now());
            INSERT INTO content (user_id, type, title, slug, data, filter, created, updated, deleted)
            VALUES (1, "page", "About page","about-page", "This is a demo page", "bbcode", now(), NULL, NULL);
            INSERT INTO roles (name, description) VALUES ("admin", "Admin role");
            INSERT INTO userroles (user_id, role_id) VALUES (1, 1);
EOD;

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();

        $this->session()->save('Success', 'Your databases tables have been installed!');
        return $this->response()->redirect('home');
    }
}