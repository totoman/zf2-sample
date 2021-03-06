<?php
namespace Member\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\InputFilter\Factory;
use Member\Model\Auth as Auth;
use Member\Model\Add\AddService;

class AuthController extends AbstractActionController
{
    /** @var AddService $addService */
    protected $addService;

    public function loginformAction()
    {
    }

    /**
     * @return Response|ViewModel
     */
    public function loginAction()
    {
        $login_id = $this->params()->fromPost('login_id');
        $password = $this->params()->fromPost('password');

        $auth = new Auth($this->getServiceLocator());
        if ($auth->login($login_id, $password)) {
            return( $this->redirect()->toUrl('/member') );
        } else {
            $view = new ViewModel();
            $view->setTemplate('member/auth/loginform.twig');
            $view->setVariables([
                'inputs' => [
                    'login_id' => $login_id,
                    'password' => $password,
                ],
                'message' => 'ログイン名かパスワードが違います',
            ]);
            return $view;
        }
    }

    /**
     * @return Response
     */
    public function logoutAction()
    {
        $auth = new Auth($this->getServiceLocator());
        $auth->logout();
        return($this->redirect()->toUrl('/auth/loginform'));
    }
}
