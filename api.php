<?php
/**
 * @Author: Veris
 * @Date:   2015-08-13 19:26:06
 * @Last Modified by:   Veris
 * @Last Modified time: 2015-08-14 13:49:54
 */
header('Content-type:text/html;charset=utf8');
require(dirname(__FILE__).'\Class\Message.class.php');
if(isset($_GET['action'])){
    $Message=new Message($config);
    switch($_GET['action']){
        case 'getNewId':
            echo $Message->getNewId()['id'];
            break;
        case 'insertMsg':
            if(isset($_POST['user']) && isset($_POST['contents']))
                echo $Message->insertMsg($_POST['user'],$_POST['contents']);
            break;
        case 'selectMsg':
            if(isset($_POST['current_id']))
                print_r(json_encode($Message->selectMsg($_POST['current_id'])));
            break;
        default:
            echo '错误请求参数！';
    }
} else {
    echo '这不是你该来的地方！';
}