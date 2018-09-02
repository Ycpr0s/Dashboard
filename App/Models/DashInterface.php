<?php

namespace App\Models;

/**
 * Interface class
 *
 * PHP version 7.0
 */
interface DashInterface
{
    
    public function getOrdersTotal();

    public function getCustomersTotal();

    public function getRevenueTotal();    

    public function getCustomersByOrders();
    
    public function getItemsBySales();
    
    public function getOrdersByRevenue();
    
    public function getOrdersByItems();
    
    
}
