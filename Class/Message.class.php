<?php
/**
 * @Author: Veris
 * @Date:   2015-08-12 22:55:50
 * @Last Modified by:   Veris
 * @Last Modified time: 2015-08-14 13:50:24
 */

/**
* 数据库类
*/

$config=array(
    'DB_TYPE'=>'mysql',
    'DB_HOST'=>'localhost',
    'DB_PORT'=>'3306',
    'DB_NAME'=>'ddq',
    'DB_USER'=>'root',
    'DB_PASS'=>'',
    'DB_PREF'=>'',
    'DB_CHAR'=>'utf8',
);

class Message{
    protected $Mysqli;
    protected $DB_TYPE;
    protected $DB_HOST;
    protected $DB_PORT;
    protected $DB_NAME;
    protected $DB_USER;
    protected $DB_PASS;
    protected $DB_PREF;
    protected $DB_CHAR;

    public function __construct($config){
        extract($config);
        $this->DB_TYPE=$DB_TYPE;
        $this->DB_HOST=$DB_HOST;
        $this->DB_PORT=$DB_PORT;
        $this->DB_NAME=$DB_NAME;
        $this->DB_USER=$DB_USER;
        $this->DB_PASS=$DB_PASS;
        $this->DB_PREF=$DB_PREF;
        $this->DB_CHAR=$DB_CHAR;
        $this->Mysqli=new mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME,$DB_PORT) or die('数据库连接失败！');
        $this->Mysqli->set_charset($DB_CHAR);
    }

    private function getAllData($sql){
        $rs=$this->Mysqli->query($sql);
        while($row=$rs->fetch_assoc()){
            $data[]=$row;
        }
        if(isset($data))
            return $data;
        return 'null';
    }

    private function getOneData($sql){
        $row=$this->Mysqli->query($sql)->fetch_assoc();
        if(isset($row))
            return $row;
        return array('id'=>'null');
    }

    public function insertMsg($user,$contents){
        if(!empty($user) && !empty($contents)){
            $user=$this->Mysqli->real_escape_string($user);
            $contents=$this->Mysqli->real_escape_string($contents);
            return $this->Mysqli->query("insert into `msg` (`user`,`contents`) values ('{$user}','{$contents}')") or die('0');
        }
    }

    public function selectMsg($current_id){
        $current_id=(int)$current_id;
        return $this->getAllData('select `user`,`contents`,`time` from msg where `id`>'.$current_id);
    }

    public function getNewId(){
        return $this->getOneData('select `id` from msg order by `time` desc limit 1');
    }

}