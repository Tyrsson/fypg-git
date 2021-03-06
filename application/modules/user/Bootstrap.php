<?php
/**
 * @author Joey Smith
 * @version 0.9.1
 * @package System
 */
require_once ('Zend/Application/Module/Bootstrap.php');
class User_Bootstrap extends System_Application_Module_Bootstrap
{

    /*
     * @var boolean flag to include front end navigation to be overridden in class childern
    */
    protected $hasFrontEndNav = true;
    /*
     * @var boolean flag to include admin navigation to be overridden in class childern
    */
    protected $hasAdminNav = true;
    /**
     * Initialize module resources
     *
     * @return mixed registry items
     */
    protected function _initUserModuleAutoloader() {
        //$this->_logger->info('Bootstrap ' . __METHOD__);

        $this->_resourceLoader = new Zend_Application_Module_Autoloader(array(
        																	 'basePath'  => APPLICATION_PATH . '/modules/user',
        																	 'namespace' => 'User_',
        																	 )
        																);
        $this->_resourceLoader->addResourceTypes(array(
        // DO NOT REMOVE
        'acl' => array(
        			'path' => 'acl/',
                    'namespace' => 'Acl'
        ),
        // DO NOT REMOVE
        'plugins' => array(
        			'path' => 'controllers/plugins',
                    'namespace' => 'Controller_Plugin')
        )
        );
        return $this->_resourceLoader;
    }
    protected function _initAcl() {
        //$this->_logger->info('Bootstrap ' . __METHOD__);
        //This sets the bootstraps the Acl Plugin
        $acl = new User_Controller_Plugin_Acl();
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new User_Controller_Plugin_Acl($acl));
    }
    protected function _initActionHelpers()
    {
        Zend_Controller_Action_HelperBroker::addHelper(new Site_Controller_Action_Helper_User());
    }
    
    public function _initRoutes() {
        $this->getRouter();
        
//         $adminIndex = new Zend_Controller_Router_Route('admin/user', array(
//             'module' => 'user',
//             'controller' => 'admin',
//             'action' => 'index',
//             'format' => 'html'
//         ), array(
//             'format' => '[a-z]+'
//         ));
//         $this->router->addRoute('admin_user', $adminIndex);
        
        
//         $route = new Zend_Controller_Router_Route(
//                 'admin/user/:userId', 
//                 array(
//                 'module' => 'user',
//                 'controller' => 'location',
//                 'action' => 'list',
//                 'userId' => null,
//                 'format' => 'html'
//         ), array(
//                 'userId' => '\d+',
//                 'format' => '[a-z]+'
//         ));
//         $this->router->addRoute('admin_list_location', $route);
        
        $route = new Zend_Controller_Router_Route(
                'admin/get/location/:locationId/:page',
                array(
                        'module' => 'user',
                        'controller' => 'location',
                        'action' => 'get',
                        'locationId' => 0,
                        'page'       => null,
                        'format' => 'html'
                ), array(
                        'locationId' => '\d+',
                        'page' => '\d+',
                        'format' => '[a-z]+'
                ));
        $this->router->addRoute('admin_get_location', $route);
        
        
        $route = new Zend_Controller_Router_Route(
                'admin/user/update/location/:locationId/:page', 
                array(
                'module' => 'user',
                'controller' => 'location',
                'action' => 'update',
                'locationId' => null,
                'page'      => null,
                'format' => 'html'
        ), array(
                'locationId' => '\d+',
                'page' => '\d+',
                //'format' => '[a-z]+'
        ));
        $this->router->addRoute('admin_update_location', $route);
        
        $route = new Zend_Controller_Router_Route(
                'admin/user/:userId/add/location/:page',
                array(
                        'module' => 'user',
                        'controller' => 'location',
                        'action' => 'add',
                        'userId' => 0,
                        'page'      => null,
                        'format' => 'html'
                ), array(
                        'userId' => '\d+',
                        'page' => '\d+',
                        //'format' => '[a-z]+'
                ));
        $this->router->addRoute('admin_add_location', $route);
        
        $route = new Zend_Controller_Router_Route(
                'admin/user/quickedit/:page',
                array(
                        'module' => 'user',
                        'controller' => 'admin',
                        'action' => 'quickedit',
                        'page'      => null,
                        //'format' => 'html'
                ), array(
                        'page' => '\d+',
                        //'format' => '[a-z]+'
                ));
        $this->router->addRoute('admin_user_quickedit', $route);
        
        ///admin/user/:page/:userId/:locationId/:sort
        
        $route = new Zend_Controller_Router_Route(
                'admin/user/:page/:userId/:locationId/:sort',
                array(
                        'module' => 'user',
                        'controller' => 'admin',
                        'action' => 'index',
                        'page'      => 1,
                        'userId'    => 0,
                        'locationId' => 0,
                        'sort'       => 'byId'
                ), array(
                        'page' => '\d+',
                        'userId'    => '\d+',
                        'locationId' => '\d+',
                        'sort'       => '[a-zA-z]+'
                ));
        $this->router->addRoute('admin_user_index', $route);
        
        
        
        
        
//         $adminIndex = new Zend_Controller_Router_Route('admin/user/create', array(
//             'module' => 'user',
//             'controller' => 'admin',
//             'action' => 'create',
//             'format' => 'html'
//         ), array(
//             'format' => '[a-z]+'
//         ));
//         $this->router->addRoute('admin_user', $adminIndex);
        
//         $registerRoute = new Zend_Controller_Router_Route(
//                 'user/register',
//                 array(
//                         'action'        => 'index',
//                         'controller'    => 'user.register',
//                         'module'        => 'user',
//                 ),
//                 array(
//                         'format'   => '[a-z]+',
//                 )
//         );
//         $this->router->addRoute('user_register_index', $registerRoute);
        
//         $verifyRoute = new Zend_Controller_Router_Route(
//                 'user/register/verify/:uid/:hash',
//                 array(
//                         'action'        => 'verify',
//                         'controller'    => 'user.register',
//                         'module'        => 'user',
//                 ),
//                 array(
//                         'uid'      => '',
//                         'hash'     => '',
//                         'format'   => '[a-z]+',
//                 )
//         );
//         $this->router->addRoute('user_register_verify', $verifyRoute);
        
//         $successRegisterRoute = new Zend_Controller_Router_Route(
//                 'user/register/success',
//                 array(
//                         'action'        => 'success',
//                         'controller'    => 'user.register',
//                         'module'        => 'user',
//                 ),
//                 array(
//                         'format'   => '[a-z]+',
//                 )
//         );
//         $this->router->addRoute('user_register_success', $successRegisterRoute);
        
//         $loginRoute = new Zend_Controller_Router_Route(
//                 'user/login',
//                 array(
//                         'action'        => 'index',
//                         'controller'    => 'user.login',
//                         'module'        => 'user',
//                 ),
//                 array(
//                         'format'   => '[a-z]+',
//                 )
//         );
//         $this->router->addRoute('user_login_index', $loginRoute);
        
//         $devLoginRoute = new Zend_Controller_Router_Route(
//                 'user/login/dev',
//                 array(
//                         'action'        => 'devlogin',
//                         'controller'    => 'user.login',
//                         'module'        => 'user',
//                 ),
//                 array(
//                         'format'   => '[a-z]+',
//                 )
//         );
//         $this->router->addRoute('user_login_dev', $devLoginRoute);
        
//         $loginSuccessRoute = new Zend_Controller_Router_Route(
//                 'user/login/dev',
//                 array(
//                         'action'        => 'success',
//                         'controller'    => 'user.login',
//                         'module'        => 'user',
//                 ),
//                 array(
//                         'format'   => '[a-z]+',
//                 )
//         );
//         $this->router->addRoute('user_login_success', $loginSuccessRoute);
        
    }
    
}