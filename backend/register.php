<?
$arResult = Billing::doPay($_GET["sessionId"])[0];
if(!is_array($arResult) && $arResult){
    echo "Заказ уже оплачен!";
    die();
}
elseif(!$arResult){
    echo "Неправильная ссылка!";
    die();
}
else{
    
}
?>