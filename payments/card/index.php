<?include $_SERVER['DOCUMENT_ROOT'].'/parts/header.php';?>
<?

$data =  array(
            "sum" => 2500,
            "nomination" => "nav12",
            "backref" => "https://yandex.ru/payments/"
            );
$data =  json_encode($data);
echo "<pre>"; print_r($data); echo "</pre>";
?>
<script>
        $(document).ready(function(){
        $.ajax({
                url:'/register/index.php',
                type:'POST',
                data:{'data':JSON.stringify(<?=$data?>)},
                success: function(href){
                    console.log(href);
                    window.location.href = href;
                }
            });
        });
</script>
<?
//echo "<pre>"; print_r(Billing::register("1000.00",'Цель 1',"sos")); echo "</pre>";
?>
<?include $_SERVER['DOCUMENT_ROOT'].'/parts/footer.php';?>
