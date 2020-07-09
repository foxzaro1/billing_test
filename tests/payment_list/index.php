<?include $_SERVER['DOCUMENT_ROOT'].'/parts/header.php';?>
<?

$data =  array(
            "dateFrom" => "2020-07-07 22:56:17",
            "dateTo" => "2020-07-09 12:56:17",
            );
$data =  json_encode($data);
?>
<script>
        $(document).ready(function(){
        $.ajax({
                url:'/info/allPayments.php',
                type:'POST',
                data:{'data':JSON.stringify(<?=$data?>)},
                success: function(res){
                    //console.log(res);
                    document.body.innerHTML += res;
                }
            });
        });
</script>
<?include $_SERVER['DOCUMENT_ROOT'].'/parts/footer.php';?>
