<?php
require_once('../../application/forms/From.php');
require_once('../../application/forms/Where.php');
require_once('../../application/forms/ExecutionQuery.php');
require_once('../../application/forms/Select.php');
require_once('../../application/forms/HelpDataEntry.php');


if(isset($_POST['select'])){
    if($_POST['select']){
        $select = new Select("");
        echo true;
    }else{
        echo false;
    }
}
if(isset($_POST['from'])){
    if($_POST['from']){
        $from = new From("");
        echo true;
    }else{
        echo false;
    }
}
