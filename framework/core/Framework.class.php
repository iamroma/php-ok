<?php

class Framework {

    public static function run() {
        echo "Framework running..";
        self::init();
        self::autoload();
        self::dispatch();
    }

    // 初始化方法
    private static function init() {
        // 定义路径常量
        define("DS", DIRECTORY_SEPARATOR);

        define("ROOT_PATH", getcwd() . DS);

        // 定义一级目录
        define("APPLICATION_PATH", ROOT_PATH . 'application' . DS);
        define("FRAMEWORK_PATH", ROOT_PATH . 'framework' . DS);
        define("PUBLIC_PATH", ROOT_PATH . 'public' . DS);

        // 定义二级目录
        define("CONFIG_PATH", APPLICATION_PATH . 'config' . DS);
        define("CONTROLLER_PATH", APPLICATION_PATH . 'controllers' . DS);
        define("MODEL_PATH", APPLICATION_PATH . 'models' . DS);
        define("VIEW_PATH", APPLICATION_PATH . 'views' . DS);

        define("CORE_PATH", FRAMEWORK_PATH . 'core' . DS);
        define("DB_PATH", FRAMEWORK_PATH . 'databases' . DS);
        define("HELPER_PATH", FRAMEWORK_PATH . 'helpers' . DS);
        define("LIB_PATH", FRAMEWORK_PATH . 'libraries' . DS);

        define("CSS_PATH", PUBLIC_PATH . 'css' . DS);
        define("IMAGE_PATH", PUBLIC_PATH . 'images' . DS);
        define("JS_PATH", PUBLIC_PATH . 'js' . DS);
        define("UPLOAD_PATH", PUBLIC_PATH . 'uploads' . DS);

        // 获取参数p、c、a,index.php?p=admin&c=goods&a=add GoodsController中的addAction
        define("PLATFORM", isset($_GET['p']) ? $_GET['p'] : 'admin');
        define("CONTROLLER", isset($_GET['c']) ? ucfirst($_GET['c']) : "Index");
        define("ACTION", isset($_GET['a']) ? $_GET['a'] : "index");

        // 设置当前控制器和视图目录 CUR-- current
        define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        define("CUR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

        // echo CUR_CONTROLLER_PATH;
        
    }

    // 路由方法
    //index.php?p=admin&c=goods&a=add GoodsController中的addAction
    private static function dispatch() {
        //获取控制器名称
        $controller_name = CONTROLLER . "Controller";
        //获取方法名
        $action_name = ACTION . "Action";
        //实例化控制器对象
        $controller = new $controller_name();
        //调用方法
        $controller->$action_name();
    }

    //注册为自动加载   
    private static function autoload() {
        $array = array(__CLASS__, "load");
        spl_autoload_register($array);
    }

    //自动加载功能,此处我们只实现控制器和数据库模型的自动加载
	//如GoodsController、 GoodsModel
    private static function load($classname) {
        if (substr($classname, -10) == "Controller") {
            //载入控制器
            include CUR_CONTROLLER_PATH . "{$classname}.class.php";
        } elseif (substr($classname, -5) == "Model") {
            //载入数据库模型
            include MODEL_PATH . "{$classname}.class.php";
        } else {
            // ...
        }
    }
}