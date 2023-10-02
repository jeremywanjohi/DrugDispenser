<?php
$pageTitle = "Full Catalog";
$section=null;

include ("drug_details/view_details.php");
include ("drug_details/functions.php");

if(isset($_GET['cat'])){
if($_GET['cat']=="antibiotics"){
    $pageTitle="Antibiotics";
    $section="antibiotics";
}else if($_GET['cat']=="painkillers"){
    $pageTitle="Painkillers";
    $section="painkillers";
}else if($_GET['cat']=="anti-inflammants"){
    $pageTitle="Anti-inflammants";
    $section="anti-inflammants";
}
}

include "view_page/header.php";?>


<div class="section catalog page">
    <div class="wrapper">
    <h1><?php echo $pageTitle;?></h1>

        <ul class="items">
           <?php 
           $categories=array_category($catalog,$section);
          foreach($categories as $id ){
            echo get_item_html($id,$catalog[$id]);
          }
           ?>
        </ul>
    </div>
</div>
<?php include "view_page/footer.php";?>