<?php
include_once("model/Model.php");
class Controller
  {
    public $model;
    public function __construct()
      {
        $this->model = new Model();
      }
    public function index()
      {
        $value            = $this->model->get_client_ip();
        $get_browser_name = $this->model->get_browser_name($_SERVER['HTTP_USER_AGENT']);
        $os               = $this->model->getOS();
        $sessionid        = str_replace("", "", $value . $get_browser_name);
        $checksessionid   = $this->model->checksessionid($sessionid);
        if ($checksessionid == true)
          {
            $sessioninformation = $this->model->sessioninformation();
            if (isset($_REQUEST['logout']) == "" && isset($_REQUEST['alllogout']) == "")
              {
                include 'view/usersessioninformation.html';
              }
            else
              {
                if (isset($_REQUEST['alllogout']))
                  {
                    $this->model->logoutall();
                  }
                else
                    $this->model->logout($_REQUEST['sessionid']);
              }
          }
        else
          {
            $validation = $this->model->index();
            include 'view/login.html';
          }
      }
    public function logout()
      {
        $this->model->logout($sessionid);
      }
  }
?>