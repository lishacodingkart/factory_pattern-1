<?php
   /*
 * Plugin Name: Design Pattern
 * Plugin URI: http://gagan.codingkloud.com/wp-admin/plugins.php
 * Description: Design Pattern.
 * Author: Gagan
 * Author URI: http://gagan.codingkloud.com
 * Version: 1.0.1
   */
 

class FactoryDesign{
public function __construct(){     
           add_action( 'wp_enqueue_scripts', array($this,'add_factory_scripts' ));                
           add_action('wp_ajax_factroyData', array($this,'factroyData'));
           add_action('wp_ajax_nopriv_factroyData', array($this,'factroyData'));

 } 
 public  function add_factory_scripts() {       
        
    wp_enqueue_script( 'my_loadmore',  plugins_url(). '/design_pattern/designPattern.js', array( 'jquery' ));
     wp_localize_script( 'my_loadmore', 'ajax_object', array( 'ajaxurl' =>admin_url( 'admin-ajax.php' ) ) );
         wp_enqueue_script( 'factory_script');
         // wp_localize_script( 'factory_script', 'ajax_admin', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
 }

                     
 public function factroyData(){
        $html="";
        $html.="<table>";       
        $oderDetails = new FactoryMain;
        $BaseTransport = new BaseTransport;
        $factory_type=$_POST["factory_type"];            
        $quantity =$_POST["quantity"];
        $oderDetails->materialquantity = $quantity;
        if ($factory_type=="2") 
        {       
        $oderDetails->cost = "12000";
        $oderDetails->totaltime = "2 Day";

        $order = $BaseTransport->create("Sea", $oderDetails);
        $html.="<tr><th>Transport by Sea</th></tr>";
        }
         else{
        $oderDetails->totaltime = "1 Day";  
        $oderDetails->cost = "10000";
        $order = $BaseTransport->create("Road", $oderDetails);
        $html.="<tr><th>Transport by Road</th></tr>";
        ?>
        <?php
         }
       $html.="<tr><td>" . $order->cost()."</td></tr>"; 
       $html.="<tr><td>" . $order->totaltime()."</td></tr>"; 
       $html.="<tr><td>" . $order->materialquantity()."</td></tr>"; 
       echo $html;   
      wp_die();  
    }

}
new FactoryDesign();


interface Transport{
     public function cost();
     public function materialquantity();
     public function totaltime();
}
class FactoryMain{
    public $cost;
    public $totaltime;
    public $materialquantity;
}
class Road implements Transport{
    private $make;
    public function __construct(FactoryMain $oderDetails) {
        $this->make = $oderDetails;
    }
    public function cost(){
        return "Total Cost (".$this->make->cost .")<br/>";
    }
    
    public function totaltime(){
        return " Delivery Time (".$this->make->totaltime .")<br/>";
    }
    public function materialquantity(){
        return "Material Quantity (".$this->make->materialquantity .")<br/>";
    }
}
class Sea implements Transport{
    private $make;
    public function __construct(FactoryMain $oderDetails) {
        $this->make = $oderDetails;
    }
    public function cost(){
        return "Total Cost (".$this->make->cost .")<br/>";
    }
    public function totaltime(){
        return " Delivery Time (".$this->make->totaltime .")<br/>";
    }
    public function materialquantity(){
        return "Material Quantity (".$this->make->materialquantity .")<br/>";
    }
}

class BaseTransport{
    public function create($class, $make)
    {
        return new $class($make);
    }
}

