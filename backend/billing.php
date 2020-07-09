<?
Class Billing {
    private static $sessionTime = 30; // Время сессии
    // Метод для отрисовки данных в форму.
    public function doPay($sessionId){
        if($register = self::checkRegisterOnSession($sessionId)){
            if($register[0]['status'] == "Y"){
                return "Y";
            }
            else{
                if(round(abs(strtotime($register[0]['time']) - strtotime(date("Y-m-d H:i:s"))) / 60,2) > self::$sessionTime){
                    $res = self::setStatus($register[0]["id"],"N");
                    echo self::createRegisterOnPay($register[0]['amount'],$register[0]['nomitation'],$register[0]['backRef'],$register[0]['hash']);
                }
                else{
                    return $register;
                }
            }
        }
        else{
            return false;
        }
    }
    // Метод, который меняет статусы 
    public function doProcessPay($id,$option){
        if($option){
            $res = self::setStatus($id,"Y");
        }
        else{
            $res = self::setStatus($id,"N");
        }
    }
    // Общий метод, который проверяет существует ли оплата по хэшу, потом проверяет его активную сессию и в случае успеха перекидывает на оплату, иначе создаем новую оплату.
    public function register($amount,$nomination,$backRef){
        try{
            $hash = self::getHash($amount,$nomination,$backRef);
            if($register = self::checkRegister($hash)){
                if(round(abs(strtotime($register[0]['time']) - strtotime(date("Y-m-d H:i:s"))) / 60,2) > self::$sessionTime){
                    $res = self::setStatus($register[0]["id"],"N");
                    echo self::createRegister($amount,$nomination,$backRef,$hash);
                }
                else{
                    echo self::LocationToPayUrl($register[0]['sessionID']);
                    //self::LocationToPay($register[0]['sessionID']);
                }
            }
            else{
                echo self::createRegister($amount,$nomination,$backRef,$hash);
            }
        }
        catch (Exception $e){
            return $e;
        }
    }
     // Метод, который проверяет оплату по хэшу
    private function checkRegister($hash){
        $db = DataBase::getDB();
        $query = "SELECT * FROM `payments` WHERE hash='".$hash."' ORDER BY `time` DESC";
        if($res = $db->select($query)){
            return $res;
        }
        else{
            return false;
        }
    }
     // Метод, который проверяет оплату по сессии (хэш+timestr)
    private function checkRegisterOnSession($sessionId){
        $db = DataBase::getDB();
        $query = "SELECT * FROM `payments` WHERE sessionID='".$sessionId."' ORDER BY `time` DESC";
        if($res = $db->select($query)){
            return $res;
        }
        else{
            return false;
        }  
    }
    // Метод, который регистрирует новую оплату
    private function createRegister($amount,$nomination,$backRef,$hash){
        $db = DataBase::getDB();
        $date = date("Y-m-d H:i:s");
        $status = "W";
        $sessionId = $hash."-".strtotime(date("Y-m-d H:i:s"));
        $query = "INSERT INTO `payments` (`nomitation`, `status`, `amount`, `time`, `backRef`, `hash`,`sessionID`) VALUES ('".$nomination."','".$status."', '".$amount."', '".$date."', '".$backRef."', '".$hash."','".$sessionId."')";
        $ink = $db->query($query);
        //self::LocationToPay($sessionId);
        return self::LocationToPayUrl($sessionId);
        //return $ink;
    }
    private function createRegisterOnPay($amount,$nomination,$backRef,$hash){
        $db = DataBase::getDB();
        $date = date("Y-m-d H:i:s");
        $status = "W";
        $sessionId = $hash."-".strtotime(date("Y-m-d H:i:s"));
        $query = "INSERT INTO `payments` (`nomitation`, `status`, `amount`, `time`, `backRef`, `hash`,`sessionID`) VALUES ('".$nomination."','".$status."', '".$amount."', '".$date."', '".$backRef."', '".$hash."','".$sessionId."')";
        $ink = $db->query($query);
        self::LocationToPay($sessionId);
        return $ink;
    }
    // Метод, который добавляет запись об оплате
    public function addBill($id,$fio,$number_card){
        $db = DataBase::getDB();
        $format_card_number = preg_replace('/[^\d]/', '', $number_card);
        $query = "INSERT INTO `bills` (`id`, `fio`, `card_number`) VALUES ('".$id."','".$fio."', '".$format_card_number ."')";
        $ink = $db->query($query);
        return $ink;
    }
    // Метод, который меняет статус оплаты
    public function setStatus($id,$status){
        $db = DataBase::getDB();
        $query = "UPDATE `payments`  SET status='".$status."' WHERE id=".$id;
        $db->query($query);
        return $db->query($query);
    }
    // Общий метод, который проверяет карту
    public function checkCard($number){
        $number = self::formatCardNumber($number);
        if(self::validateCardNumbersSum($number) && self::validateCardAlgorythmLuna($number)){
            return true;
        }
        return false;
    }
    // Метод, который проверяет карту по алгоритму Луна
    private function validateCardAlgorythmLuna($number){
        $number = strrev($number);
        $sum = 0;
        for ($i = 0, $j = strlen($number); $i < $j; $i++) {
            if (($i % 2) == 0) {
                $value = $number[$i];
            } else {
                $value = $number[$i] * 2;
                if ($value > 9)  {
                    $value -= 9;
                }
            }
            $sum += $value;
        }
        return (($sum % 10) === 0);
    }
    // Метод, который проверяет количество цифр в карте
    private function validateCardNumbersSum($number){
        return (iconv_strlen($number) == 16) ? true : false;
    }
    // Метод, который преобразует для Алгоритма проверки
    private function formatCardNumber($number){
        return strrev(preg_replace('/[^\d]/', '', $number));
    }
    // Метод, который делает хэш
    private function getHash($amount,$nomination,$date){
        return md5($amount.$nomination.$date);
    }
    // Метод, который отправляет на форму оплаты
    private function LocationToPay($hash){
        header('Location: /payments/card/form?sessionId='.$hash);
    }
    private function LocationToPayUrl($hash){
        //for local
        return '/payments/card/form?sessionId='.$hash;
        //return $_SERVER['SERVER_ADDR'].'/payments/card/form?sessionId='.$hash;
    }
    // Метод, который возвращает на сайт с которого пришли
    private function LocationToBackUrl($backurl){
        header('Location: '.$backurl.'/register');
    }
    public function findPaymentsInDateRange($dateFrom,$dateTo){
        $db = DataBase::getDB();
        $query = "SELECT * FROM `payments` WHERE time>='".$dateFrom."' AND time<='".$dateTo."' ORDER BY `time` ASC";
        if($res = $db->select($query)){
            return $res;
        }
        else{
            return false;
        }
    }
}