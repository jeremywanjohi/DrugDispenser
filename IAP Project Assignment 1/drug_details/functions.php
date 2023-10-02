<?php
function get_item_html($id,$item) {
    $output= "<li><a href='#'<img src='".$item["img"]."'
             alt='".$item["title"]."'><p>View Details</p></a></li>";
    return $output;
}

function array_category($catalog, $category) {
    $output = array();
    
    foreach ($catalog as $id => $item) {
        if (strtolower ($category)==strtolower($item["category"])){
            $output[]=$id;
        }
                 
        
    }
    
    return $output;

}