# Dashboard 

Requirements:

   * PHP application should be based on MVC structure
   * Have at least one abstract class and one interface
   * Use namespaces
   * PSR-4 standard (http://www.php-fig.org/psr/psr-4/)
   * No framework should be used
 
 * Create a database structure
   * * Order - purchase date, country, device
   * * Order items - EAN, quantity, price
   * * Customer - first name, last name, email
   * * Customer has 1 to many connection with Order
   * * Order has 1 to many connection with Order items

   * Create a simple dashboard that shows statistics for:
   * * Total number of orders
   * * Total revenue amount
   * * Total number of customers

   * * Top 10 customers (based on how many orders were placed)
   * * Top 10 selling items
   * * Top 10 orders by revenue
   * * Top 10 orders by item count
   
   * Statistics by default should be based on last month, with an option to change to any time period (to & from).
   * Create 1 month timeframe chart with customers and orders 
