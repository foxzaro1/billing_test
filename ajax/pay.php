<?
include $_SERVER['DOCUMENT_ROOT'].'/backend/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/backend/billing.php';

$data = json_decode($_REQUEST['data']);
$dataOrder = json_decode($_REQUEST['orderData']);
if(Billing::checkCard($data->CARD_NUMBER)){
    Billing::doProcessPay($dataOrder->id,true);
    Billing::addBill($dataOrder->id,$data->NAME_ON_CARD,$data->CARD_NUMBER);
    echo json_encode($dataOrder);
}
else{
    Billing::doProcessPay($dataOrder->id,false);
    echo false;
}
?>