<?php

class IndexController extends CoreController {

    //生成验证码
    public function codeAction() {
        //载入验证码类
        $this->library("Captcha");
        $c = new Captcha();
        $c->generateCode();
    }

    public function indexAction() {
        // echo "Admin IndexController indexAction go.";
        include CUR_VIEW_PATH . "index.html";
    }

    public function topAction() {
        include CUR_VIEW_PATH . "top.html";
    }

    public function menuAction() {
        include CUR_VIEW_PATH . "menu.html";
    }

    public function mainAction() {
        $admin = new AdminModel('admin');
        $admins = $admin->getAdmins();
        var_dump($admins);
        include CUR_VIEW_PATH . "main.html";
    }

    public function dragAction() {
        include CUR_VIEW_PATH . "drag.html";
    }
}