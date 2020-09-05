<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
 
if(isset($HTTP_RAW_POST_DATA)) {
  parse_str($HTTP_RAW_POST_DATA,$arr); 
  $arr['extra']='1.POST Request from hayageek.com';
  echo json_encode($arr);
}
else
{
    $_POST['extra']='2.POST Request from hayageek.com';
  //  echo json_encode($_POST);
 $name = $_POST['name'];
 $varientss = $_POST['varientss'];
    
    
    
    
    
 //if($age == "22222")
 //{
// echo '<img src="https://bouteeki-mockup.herokuapp.com/image.jpg" style="max-width:50%;">';
 //} else {
 // echo "Code is not correct";
// }
 //echo $name." - ".$age;
 //echo "aman";





$SHOPIFY_SHOP = 'roop-darshan-ltd.myshopify.com'; //For eg: storedenavin.myshopify.com

function getorder($url)
{
$ch = curl_init($url);      
//curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',  
    'Authorization: Basic NjJhOTAxMjVkMDE3OGFiZjUwMzQxNzAwMmM3ZTE3OWM6c2hwcGFfM2I2ZWQzNTU0NThhOGU2NDc5MjViMDUxOGQ3NTIxZmQ=')                                                                     
);                                                                                                                   
$output = curl_exec($ch);
curl_close($ch); 
$json_data_shopify = json_decode($output,true);   
return $json_data_shopify;
}


//$productss = getorder("https://".$SHOPIFY_SHOP."/admin/api/2020-07/products/4665553748050.json");
$productss_var = getorder("https://".$SHOPIFY_SHOP."/admin/api/2020-07/variants/".$varientss.".json");


$inventory_item_id = $productss_var['variant']['inventory_item_id'];
//echo $inventory_item_id;


$productss_var_lock = getorder("https://".$SHOPIFY_SHOP."/admin/api/2020-07/inventory_levels.json?inventory_item_ids=".$inventory_item_id);
//print_r($productss_var_lock);

$inventory_levels = $productss_var_lock['inventory_levels'];

foreach ($inventory_levels as $key3 => $value3) {
    
    $location_id = $inventory_levels[$key3]['location_id'];
    $available = $inventory_levels[$key3]['available'];
    //echo $location_id." - ".$available."<br>";
    $location_id_name = getorder("https://".$SHOPIFY_SHOP."/admin/api/2020-07/locations/".$location_id.".json");
    echo $location_id_name['location']['name']." - ".$available."<br>";
    
}




}
?>
