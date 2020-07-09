<?
include $_SERVER['DOCUMENT_ROOT'].'/backend/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/backend/billing.php';
?>
<?
$data = json_decode($_REQUEST["data"]);
echo Billing::register($data->sum,$data->nomination,$data->backref);
?>
