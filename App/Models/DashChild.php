<?php

namespace App\Models;

use PDO;

/**
 * Child class extends base Model, implements Interface
 *
 * PHP version 7.0
 */
class DashChild extends \Core\Model implements DashInterface {

    private $dateFrom;
    private $dateTo;
    private $db;
    
   public function __construct($dateFrom, $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->db = static::getDB();
    }
    
    public function getOrdersTotal()
    {        
       $stmt = $this->db->prepare("
                             SELECT COUNT(1) 
                             FROM `order` 
                             WHERE `purchase date` >= :fromDate 
                               AND `purchase date` <= :toDate
                            ");
       $stmt->execute([":fromDate"=>$this->dateFrom, ":toDate"=>$this->dateTo]);
       return $stmt->fetchColumn();
    }
    
    public function getCustomersTotal()
    {
       $stmt = $this->db->prepare("
                             SELECT COUNT(DISTINCT customer_id) 
                             FROM `order`
                             WHERE `purchase date` >= :fromDate 
                               AND `purchase date` <= :toDate
                             ");
       $stmt->execute([":fromDate"=>$this->dateFrom, ":toDate"=>$this->dateTo]);
       return $stmt->fetchColumn();
    }
    
    public function getRevenueTotal()
    {        
       $stmt = $this->db->prepare("
                             SELECT SUM(i.quantity * i.price) 
                             FROM   `order items` i 
                                LEFT JOIN `order` o 
                                       ON i.order_id = o.id 
                             WHERE o.`purchase date` >= :fromDate 
                               AND o.`purchase date` <= :toDate
                            ");
       $stmt->execute([":fromDate"=>$this->dateFrom, ":toDate"=>$this->dateTo]);
       return $stmt->fetchColumn();
    }    
    
    public function getCustomersByOrders()
    {        
        $stmt = $this->db->prepare("SELECT  c.`first name` AS first_name
                                    , c.`last name` AS last_name
                                    , COUNT(o.customer_id) AS counter 
                                    FROM `order` o 
                                    INNER JOIN customer c 
                                        ON o.customer_id = c.id 
                                    WHERE o.`purchase date` >= :fromDate 
                                    AND o.`purchase date` <= :toDate
                                    GROUP BY o.customer_id 
                                    ORDER BY COUNT(*) 
                                    DESC 
                                    LIMIT 10
                                    ");
        $stmt->execute([":fromDate"=>$this->dateFrom, ":toDate"=>$this->dateTo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }  
    
    public function getItemsBySales()
    {         
        $stmt = $this->db->prepare("
                              SELECT i.EAN
                                   , SUM(i.quantity) AS sales 
                              FROM `order items` i 
                              LEFT JOIN `order` o
                                     ON i.order_id = o.id 
                             WHERE o.`purchase date` >= :fromDate 
                               AND o.`purchase date` <= :toDate
                              GROUP BY EAN 
                              ORDER BY sales 
                              DESC 
                              LIMIT 10
                              ");
        $stmt->execute([":fromDate"=>$this->dateFrom, ":toDate"=>$this->dateTo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }
    
    public function getOrdersByRevenue()
    {         
        $stmt = $this->db->prepare("
                              SELECT i.order_id
                                   , SUM(i.quantity * i.price) AS revenue 
                              FROM `order items` i
                              LEFT JOIN `order` o
                                     ON i.order_id = o.id 
                             WHERE o.`purchase date` >= :fromDate 
                               AND o.`purchase date` <= :toDate
                              GROUP BY i.order_id 
                              ORDER BY revenue 
                              DESC 
                              LIMIT 10
                              ");
        $stmt->execute([":fromDate"=>$this->dateFrom, ":toDate"=>$this->dateTo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }    
    
    public function getOrdersByItems()
    {         
        $stmt = $this->db->prepare("
                              SELECT i.order_id 
                                   , SUM(i.quantity) AS items 
                              FROM `order items` i
                              LEFT JOIN `order` o
                                     ON i.order_id = o.id 
                             WHERE o.`purchase date` >= :fromDate 
                               AND o.`purchase date` <= :toDate
                              GROUP BY i.order_id 
                              ORDER BY items 
                              DESC 
                              LIMIT 10
                              ");
        $stmt->execute([":fromDate"=>$this->dateFrom, ":toDate"=>$this->dateTo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }

}
