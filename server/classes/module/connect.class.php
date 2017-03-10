<?php
class connect{
    static $instance = false;
    static $time = false;

    static function getTime(){
        if(self::$time == false){
            self::$time = self::get_millisecond();
        }
        return self::$time;
    }
    private static function get_millisecond()
    {
        list($usec, $sec) = explode(" ", microtime());
        $msec=round($usec*1000);
        return $sec.$msec;
    }

    static function getInstance(){
        if(self::$instance == false){
            if(self::$time == false){
                self::$time = self::get_millisecond();
            }
            self::$instance = new mysqli('127.0.0.1', 'root', '', 'packet');
            if(mysqli_connect_errno())
            {
                echo mysqli_connect_error();
                exit;
            }
        }

        return self::$instance;
    }

    /**
     * query 查询
     * @param $sql
     * @return bool
     */
    static function select($sql,$single = false){
        $result = self::getInstance()->query($sql);
        if($result === false)
        {
            return false;
        }
        if($result->num_rows <=0){
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $results_array[] = $row;
        }
        if($single){
            return $results_array[0];
        }

        return $results_array;
    }

    /**
     * 获取sql总数
     * @param $sql
     * @return bool
     */
    static function count($sql){
        if($ret = connect::select($sql,true)){
            return current($ret);
        }
        return 0;
    }

    /**
     * 查询
     * @param $sql
     * @return bool|mysqli_result
     */
    static function query($sql){
        if($ret = self::getInstance()->query($sql)){
            return self::getInstance()->affected_rows;
        }
        return false;
    }

    /**
     * 插入
     * @param $sql
     * @return bool
     */
    static function insert($sql){
        if($ret = self::getInstance()->query($sql)){
            return self::getInstance()->insert_id;
        }
        return false;
    }

    /**
     * 开启事务
     */
    static function openCommit(){
        self::getInstance()->autocommit(FALSE); //关闭自动提交功能
    }

    /**
     * 提交事务
     */
    static function submitCommit(){
        self::getInstance()->commit(); //关闭自动提交功能
        self::getInstance()->autocommit(true); //关闭自动提交功能
    }

    /**
     * 关闭事务
     */
    static function rollback(){
        self::getInstance()->rollback(); //关闭自动提交功能
        self::getInstance()->autocommit(true); //关闭自动提交功能
    }


    static function tablename($table){
        return 'jnp_'.$table;
    }
}