<?php

use Phalcon\Mvc\User\Component;

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Component
{

    private $_headerMenu = array(
        'navbar-left' => array(
            'index' => array(
                'caption' => 'Home',
                'action' => 'index'
            ),
            'calendar' => array(
                'caption' => 'Calendar',
                'action' => 'index'
            ),
            /*'marketplace' => array(
                'caption' => 'Marketplace',
                'action' => 'index'
            ),*/
            'about' => array(
                'caption' => 'About',
                'action' => 'index'
            )
        ),
        'navbar-right' => array(
            'session' => array(
                'caption' => 'Log In/Sign Up',
                'action' => 'index'
            ),
        )
    );

    private $_tabs = array(
        'Overview' => array(
            'controller' => 'dashboard',
            'action' => 'index',
            'any' => false
        ),
        'My Offers' => array(
            'controller' => 'dashboard',
            'action' => 'offers',
            'any' => false
        ),
        'Privacy' => array(
            'controller' => 'dashboard',
            'action' => 'privacy',
            'any' => false
        ),
        'My Profile' => array(
            'controller' => 'dashboard',
            'action' => 'profile',
            'any' => false
        )
    );

    

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu() {
        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_headerMenu['navbar-left']['dashboard'] = array(
                'caption' => 'Profile',
                'action' => 'index'
            );
            $this->_headerMenu['navbar-right']['session'] = array(
                'caption' => 'Log Out',
                'action' => 'end'
            );
            
        } else {
            unset($this->_headerMenu['navbar-left']['invoices']);
        }

        $controllerName = $this->view->getControllerName();
        foreach ($this->_headerMenu as $position => $menu) {
            echo '<div id="collapsingnavbar" class="want-to-collapse collapse in">';
            echo '<ul class="nav navbar-nav ', $position, '">';
            foreach ($menu as $controller => $option) {
                if ($controllerName == $controller) {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                echo $this->tag->linkTo($controller . '/' . $option['action'], $option['caption']);
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }

    }

    /**
     * Returns menu tabs
     */
    public function getTabs() {
        $controllerName = $this->view->getControllerName();
        $actionName = $this->view->getActionName();
        echo '<ul class="nav nav-tabs">';
        foreach ($this->_tabs as $caption => $option) {
            if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            echo $this->tag->linkTo($option['controller'] . '/' . $option['action'], $caption), '</li>';
        }
        echo '</ul>';
    }

    //these are the panels that will appear on the homepage of the website, the appear variable determines when they appear
    // 0 only not logged in
    // 1 only logged in
    // 2 all the time
    private $_mainPanels = array(
        'welcome' => array(
            'appear' => 2,
            'path' => 'homepage-panels/welcome',
            'padding' => '150px 0'
        ),
        'stats' => array(
            'appear' => 2,
            'path' => 'homepage-panels/stats',
            'padding' => '50px 0'
        ),
        'market_snapshot' => array(
            'appear' => 1,
            'path' => 'homepage-panels/market',
            'padding' => '50px 0'
        ),
        'development' => array(
            'appear' => 1,
            'path' => 'homepage-panels/development',
            'padding' => '50px 0'
        ),
        'authenticate' => array(
            'appear' => 0,
            'path' => 'homepage-panels/authenticate',
            'padding' => '50px 0'
        ),/*
        'community' => array(
            'appear' => 0,
            'path' => 'homepage-panels/community'
        ),*/
        /*'user' => array(
            'appear' => 1,
            'path' => 'homepage-panels/user'
        ),
        'alternates' => array(
            'appear' => 2,
            'path' => 'homepage-panels/alternates'
        ),
        'pangea' => array(
            'appear' => 2,
            'path' => 'homepage-panels/pangea'
        ),
        'calendar' => array(
            'appear' => 2,
            'path' => 'homepage-panels/brownbites'
        )*/
    );

    /**
     * returns main menu panels
     */
    public function getMainPanels() {
        $auth = $this->session->get('auth');
        // This filters the different panels for whether the user is logged in
        foreach ($this->_mainPanels as $name => $info) {
            // Conditionals done with a table
            if ($auth && $info['appear']) {
                $paths[$name] = $info;
            } else if (!$auth && $info['appear'] != 1) {
                $paths[$name] = $info;
            }
        }
        return $paths;

    }
}
