<?
if($_GET["sessionId"]){
    try{
        include $_SERVER['DOCUMENT_ROOT'].'/backend/register.php';
        ?>
        <div class="container">
        <div id="Checkout" class="inline">
            <h1>Оплата онлайн</h1>
            <div class="card-row">
                <span class="visa"></span>
                <span class="mastercard"></span>
                <span class="amex"></span>
                <span class="discover"></span>
            </div>
            <form>
                <div class="form-group">
                    <label for="PaymentAmount">Сумма заказа "<?=$arResult["nomitation"]?>"</label>
                    <div class="amount-placeholder">
                    
                        <span><?=$arResult["amount"]?></span>
                        <span>₽</span>
                    </div>
                </div>
                <div class="form-group">
                    <label or="NameOnCard">Имя на карте</label>
                    <input id="NameOnCard" NAME="NAME_ON_CARD" class="form-control" type="text" maxlength="255"></input>
                </div>
                <div class="form-group">
                    <label for="CreditCardNumber">Номер карты</label>
                    <input id="CreditCardNumber" NAME="CARD_NUMBER" class="null card-image form-control mask-card-number" type="text"></input>
                </div>
                <div class="expiry-date-group form-group">
                    <label for="ExpiryDate">Годна до</label>
                    <input id="ExpiryDate" NAME="DATE_ON_CARD" class="form-control mask-card-date" type="text" placeholder="MM / YY" maxlength="7"></input>
                </div>
                <div class="security-code-group form-group">
                    <label for="SecurityCode">CVC</label>
                    <div class="input-container" >
                        <input id="SecurityCode" NAME="CVC_ON_CARD" class="form-control mask-card-code" type="text" ></input>
                        <i id="cvc" class="fa fa-question-circle"></i>
                    </div>
                    <div class="cvc-preview-container two-card hide">
                        <div class="amex-cvc-preview"></div>
                        <div class="visa-mc-dis-cvc-preview"></div>
                    </div>
                </div>
                <button id="PayButton" class="btn btn-block btn-success submit-button" type="submit">
                    <span class="submit-button-lock"></span>
                    <span class="align-middle">Оплатить <?=$arResult["amount"]?> ₽</span>
                </button>
            </form>
        </div>
        </div>
        <script>
        $(document).ready(function(){
            $('.mask-card-number').mask('9999 9999 9999 9999');
            $('.mask-card-date').mask('99/99');
            $('.mask-card-code').mask('999');
            $( "#Checkout" ).submit(function( event ) {
                event.preventDefault();
                let $data = {};
                $("#Checkout").find('input').each(function() {
                    $data[this.name] = $(this).val();
                });
                $.ajax({
                    url:'/ajax/pay.php',
                    type:'POST',
                    data:{'data':JSON.stringify($data),'orderData':JSON.stringify(<?=json_encode($arResult)?>)},
                    success: function(html){
                        try {
                            var res = JSON.parse(html);
                        }
                        catch (e) {
                            var res = false;
                        }
                        $("#Checkout form").hide();
                        if(res){
                            $("#Checkout h1").text("Оплата произведена успешно").css({"background-color" : "#96f58a","color":"#ffffff"});
                            setTimeout( 'location="'+res.backRef+'";', 5000 );
                        }
                        else{
                            $("#Checkout h1").text("Не удалось произвести  оплату").css({"background-color" : "#ff2c2c","color":"#ffffff"});
                        }
                        //alert(res); // распарсим JSON
                    }
                });
            });
        });
        </script>
        <?
    }
    catch (Exception $e){
        return $e;
    }
}
?>