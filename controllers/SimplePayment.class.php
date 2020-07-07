<?php

use Luhn\Luhn;

class SimplePayment extends Controller {

    private $creditCardNumber;
    private $expireMonth;
    private $expireYear;
    private $amount;
    public $errors = [];
    public $res = [];

    function __construct() {
        parent::__construct();
       
        $this->creditCardNumber = isset($_POST['ccn']) ? $_POST['ccn'] : null;
        $this->expireMonth = isset($_POST['expire_month']) ? $_POST['expire_month'] : null;
        $this->expireYear = isset($_POST['expire_year']) ? $_POST['expire_year'] : null;
        $this->amount = isset($_POST['amount']) ? $_POST['amount'] : null;
    }

    public function index() {
        
        // various input values validation
        if (!ctype_digit($this->creditCardNumber)) {
            $this->errors['ccn_error']['digit_error'] = 'The Credit Card Number should contain only numbers!';
        }
        else {
            if (strlen($this->creditCardNumber) < 16) {
                $this->errors['ccn_error']['length_error'] = 'The lenght of the Credit Card Number is less than 16!';
            }
            if (!Luhn::isValid($this->creditCardNumber)) {
                $this->errors['ccn_error']['invalid_ccn_error'] = 'The Credit Card Number is invalid!';
            }
        }

        if (((int)$this->expireMonth <= (int)(date('m')) && $this->expireYear == date('Y')) || $this->expireYear < date('Y')) {
            $this->errors['date_error']['invalid_year'] = 'The expiration date is invalid!';
        }

        if (!ctype_digit($this->amount) || $this->amount < 1 || $this->amount > 1000000) {
            $this->errors['amount_error']['invalid_number'] = 'The amount should be number between 1 - 1000000!';
        }
        
        // get the converting value from API
        if (empty($this->errors['errors'])) {
            $json = file_get_contents('https://free.currconv.com/api/v7/convert?apiKey=5d2cf53d2ed461542f0b&q=HUF_EUR');
            $obj = json_decode($json, true);
            $convertion_ratio =  $obj['results']['HUF_EUR']['val'];
            $this->res['converted_value'] = number_format((int)$this->amount * $convertion_ratio, 2);
        }
        
        $this->res['ccn'] = $this->creditCardNumber;
        $this->res['expire_month'] = $this->expireMonth;
        $this->res['expire_year'] = $this->expireYear;
        $this->res['amount'] = $this->amount;

        $result = array_merge($this->errors, $this->res);

        // render the view
        $this->assign('data', $result);
        echo $this->render('home');
    }

    public function showPage($page) {
        $result = ['data'];
        $this->assign('data', $result);
        echo $this->render($page);
    }
    
    public function showError($errors, $index) {
        if (isset($errors[$index]) && !empty($errors[$index])) {
            foreach ($errors[$index] as $error) {
                echo '<span style="color: red;">' . $error . '</span>' . '<br>';
            }
        }
    }
}


