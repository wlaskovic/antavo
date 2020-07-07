<?php
include_once('views/header.php');
?>
<form name="sipmle_payment" method="POST" action="./SimplePayment">
    <div>
        <label for="ccn">Credit Card Number:</label>
        <input id="ccn" name="ccn" type="text" style="width: 250px;"  value="<?= isset($this->data['data']['ccn']) ? $this->data['data']['ccn'] : ''; ?>"
        inputmode="numeric" pattern="[0-9]{16}" maxlength="16" placeholder="Fill only with numbers - (16)" required>
        <br >
        <?= $this->showError($this->data['data'], 'ccn_error') ?>
    </div>
    <div>
        <label>Expire date:</label>
        <select name="expire_month" required>
            <option value="01">Jan</option>
            <option value="02">Feb</option>
            <option value="03">Mar</option>
            <option value="04">Apr</option>
            <option value="05">May</option>
            <option value="06">Jun</option>
            <option value="07">Jul</option>
            <option value="08">Aug</option>
            <option value="09">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>
        <select name="expire_year" required>
            <option value="">Year</option>
            <?php
             for ($i = date('Y'); $i < date('Y') + 10; $i++) {
                echo '<option value=' . $i . ' ', (isset($this->data['data']['expire_year']) && $this->data['data']['expire_year'] == $i) ? ' selected ' : '' ,'>' . $i . '</option>';
            } ?>
        </select>
        <br >
        <?= $this->showError($this->data['data'], 'date_error') ?>
    </div>
    <div>
        <label>Amount to pay (HUF):</label>
        <input type="number" name="amount" value="<?= isset($this->data['data']['amount']) ? $this->data['data']['amount'] : ''; ?>" min="1" max="1000000" required/>
        <br >
        <?= $this->showError($this->data['data'], 'amount_error') ?>
    </div>
    <br >
    <div>
        <button class="submit-button" type="submit">Payment</button>
    </div>
    <div>
        <?php
         if (isset($this->data) && isset($this->data['data']['converted_value'])) {
            echo 'You have paid ' . $this->data['data']['amount'] . ' HUF which is <span><b>' . $this->data['data']['converted_value'] . '</b> EUR</span>';
         }
        ?> 
    </div>
</form>
<?php
include_once('views/footer.php');