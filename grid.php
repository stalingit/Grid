<?php

require_once('error_handler.php');
require_once('grid.class.php');
// the default action is 'load'
$action = 'load';
if(isset($_GET['action']))
$action = $_GET['action'];
// load the grid
if($action == 'load')
{
// get the requested page
$page = $_POST['page'];
// get how many rows we want to have into the grid
$limit = $_POST['rows'];
// get index row - i.e. user click to sort
$sidx = $_POST['sidx'];
// get the direction
$sord = $_POST['sord'];
$grid = new Grid($page, $limit, $sidx, $sord);
$response->page = $page;
$response->total = $grid->getTotalPages();
$response->records = $grid->getTotalItemsCount();
$currentPageItems = $grid->getCurrentPageItems();
for($i=0;$i<count($currentPageItems);$i++) {
$response->rows[$i]['id'] =
$currentPageItems[$i]['product_id'];
$response->rows[$i]['cell']=array(
$currentPageItems[$i]['product_id'],
$currentPageItems[$i]['name'],
$currentPageItems[$i]['price'],
$currentPageItems[$i]['on_promotion']
);
}
echo json_encode($response);
}
// save the grid data
elseif ($action == 'save')
{
$product_id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$on_promotion = ($_POST['on_promotion'] =='Yes') ? 1 : 0;
$grid = new Grid();
echo $grid->updateItem($product_id, $on_promotion, $price,
$name);
}
?>