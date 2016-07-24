<?php
header("Content-Type:text/html;charset=utf-8");
$city = array(
	array('id' => 1,'name' => '北京',"pid" => 0),
	array('id' => 2,'name' => '广东',"pid" => 0),
	array('id' => 3,'name' => '海淀区',"pid" => 1),
	array('id' => 4,'name' => '昌平区',"pid" => 1),
	array('id' => 5,'name' => '上地',"pid" => 3),
	array('id' => 6,'name' => '西二旗',"pid" => 3),
	array('id' => 7,'name' => '回龙观',"pid" => 4),
	array('id' => 8,'name' => '霍营',"pid" => 4),
	array('id' => 9,'name' => '深圳',"pid" => 2),
	array('id' => 10,'name' => '广州',"pid" => 2),
	array('id' => 11,'name' => '福田',"pid" => 9),
	array('id' => 12,'name' => '南山',"pid" => 9),
);
/*
	$res = array(
		array('id' => 1,'name' => '北京',"pid" => 0),
		array('id' => 3,'name' => '海淀区',"pid" => 1),
		array('id' => 5,'name' => '上地',"pid" => 3),
		array('id' => 6,'name' => '西二旗',"pid" => 3),
		array('id' => 4,'name' => '昌平区',"pid" => 1),
		array('id' => 7,'name' => '回龙观',"pid" => 4),
		array('id' => 8,'name' => '霍营',"pid" => 4),
		array('id' => 2,'name' => '广东',"pid" => 0),
		array('id' => 9,'name' => '深圳',"pid" => 2),
		array('id' => 11,'name' => '福田',"pid" => 9),
		array('id' => 12,'name' => '南山',"pid" => 9),
		array('id' => 10,'name' => '广州',"pid" => 2),
	);
*/
// $res = array();
function tree($arr,$pid = 0){
	//$res = array(); //$res是一个局部变量
	static $res = array();
	// global $res;
	foreach ($arr as $v) {
		if ($v['pid'] == $pid ) {
			//说明找到,首先保存
			$res[] = $v;
			//改变添加，找当前分类的后代分类，就是递归
			tree($arr,$v['id']);
		}
	}
	return $res;
}
echo "<pre>";
var_dump($city);
echo "<hr />";
$new = tree($city);
var_dump($new);