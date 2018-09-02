<?php

namespace App\Controllers;

use App\Models\DashChild;

use App\Models\FormValidator;

use \Core\View;

/**
 * Index controller extends base Controller
 *
 * PHP version 7.0
 */
class DashController extends \Core\Controller
{
    
    /**
     * Load default dates
     *
     * @return void
     */    
    public function __construct() {
        
        $dateObjFrom = new \DateTime('first day of last month');
        $dateObjTo = new \DateTime('last day of last month');   
        
        $this->dateFrom = $dateObjFrom->format('Y-m-d');
        $this->dateTo = $dateObjTo->format('Y-m-d');
        
    }
    
     /**
     * Load desired lists to index page
     *
     * @return void
     */   
    public function indexAction()
    {
        
        $this->searchAction();    
        $dashboard = new DashChild($this->dateFrom, $this->dateTo);
                        
        $model = array('ordersTotal'        => $dashboard->getOrdersTotal(),
                       'customersTotal'     => $dashboard->getCustomersTotal(),
                       'revenueTotal'       => $dashboard->getRevenueTotal(),
                       'customersByOrders'  => $dashboard->getCustomersByOrders(),
                       'itemsBySales'       => $dashboard->getItemsBySales(),
                       'ordersByRevenue'    => $dashboard->getOrdersByRevenue(),
                       'ordersByItems'      => $dashboard->getOrdersByItems(),
                       'dateFrom'           => $this->dateFrom,
                       'dateTo'             => $this->dateTo
                       );
                        
        return View::renderTemplate('Main/dashView.html', $model);

    }
    
     /**
     * Overwrites default dates if $_POST is valid
     *
     * @return void
     */     
    public function searchAction() {
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                if (FormValidator::isValidDate($_POST['dateFrom']) && FormValidator::isValidDate($_POST['dateTo'])) {                      
                    
                        $this->dateFrom = $_POST['dateFrom'];
                        $this->dateTo = $_POST['dateTo'];
  
                }    
            }
    }
}

