<?php

namespace App\Controller;

use App\Model\UserModel;
use App\PasswordService;
use Core\Controller;
use Core\Session;
use Core\Validator;

class AuthController extends Controller
{

    private $userModel;

    public function __construct($request, $userModel)
    {
        parent::__construct($request);
        $this->userModel = $userModel;
    }

    public function postUser() {
        $userType = Validator::sanitize($this->request->getAttribute('user_type'), 'int');
        if($userType != 0 && $userType != 1) {
            $this->view->render('login/create_login', ['message' => 'Requisição inválida']);
        }
        $input = [
            'name' => [$this->request->getAttribute('name'), 'string'],
            'email' => [$this->request->getAttribute('email'), 'email'],
            'password' => [$this->request->getAttribute('password'), 'string'],
            'birth' => [$this->request->getAttribute('birth'), 'string'],
        ];
        $schema = Validator::validate($input);
        $schema['result']['user_type'] = $userType;
        $schema['result']['password'] = (new PasswordService())->hash($schema['result']['password']);
        $schema['result']['accept'] = true;
        $schema['result']['welcome'] = true;
        if(!empty($schema['errors'])) {
            $this->view->render('login/create_login', ['message' => 'Campos inválidos']);
        }
        if($schema['result']['user_type'] == UserModel::USER_TYPE_AGENT) {
            $schema['result']['accept'] = false;
            $schema['result']['welcome'] = false;
        }
        $this->userModel->create($schema['result']);
        $this->view->redirect('login');
    }

    public function postLogin() {
        $input = [
            'email' => [$this->request->getAttribute('email'), 'email'],
            'password' => [$this->request->getAttribute('password'), 'string'],
        ];
        $schema = Validator::validate($input);
        $user = $this->userModel->findUserByEmail($schema['result']['email']);
        if(!empty($user)) {
            $passwordService = new PasswordService();
            if($passwordService->compare($schema['result']['password'], $user['password'])){
                Session::set("user_type", $user['user_type']);
                Session::set("user_id", $user['id']);
                Session::set("name", $user['name']);
                Session::set("welcome", $user['welcome']);
                Session::set("accept", $user['accept']);
                if($user['user_type'] == UserModel::USER_TYPE_ADMIN) {
                    $this->view->redirect('approve');
                }
                if($user['user_type'] == UserModel::USER_TYPE_AGENT && !$user['welcome']) {
                    $this->view->redirect('create-agency');
                }else {
                    $this->view->redirect('welcome');
                }
            }
        }
        $this->view->render('login/login', ['message' => 'Credenciais incorretas']);
    }

}