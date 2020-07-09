<?
include $_SERVER['DOCUMENT_ROOT'].'/backend/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/backend/billing.php';
?>
<?
$data = json_decode($_REQUEST["data"]);
print_r(Billing::findPaymentsInDateRange($data->dateFrom,$data->dateTo));
?>
