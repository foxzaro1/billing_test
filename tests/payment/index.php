<?include $_SERVER['DOCUMENT_ROOT'].'/parts/header.php';?>
<?

$data =  array(
            "sum" => 12252500,
            "nomination" => "test",
            "backref" => "https://yandex.ru/payments/"
            );
$data =  json_encode($data);
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
<?include $_SERVER['DOCUMENT_ROOT'].'/parts/footer.php';?>
