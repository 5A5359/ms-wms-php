<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<?php
    include "../basic/include.php";
    include "../basic/database.php";

$date = $_POST[date];
$yewuyuan = $_POST[yewuyuan];
$type = $_POST[type];
$company = $_POST[company];
$warehouse = $_POST[warehouse];
$remark = $_POST[remark];
$itemstr = $_POST[item_str];

//echo "$yewuyuan||$date||$company||$warehouse||$type||$itemstr";die();

if($yewuyuan==''||$date==''||$company==''||$warehouse==''||$type==''||$itemstr=='' )//$id==''||
    $error='提交的表单有误！';
else
{    
    $date2 = date("ymd");
    $id = $date2."00";
    
    if(mysql_query("select * from table_warehouse_$warehouse")==false)//检查目标仓库书库表是否健在
        die("仓库$warehouse不存在！");
        
    $query = "select * from test_receipt where id = '$id'";
    $result = mysql_query($query);
    $RS = mysql_fetch_array($result);
    
    while(!empty($RS)){
        if(($id = next_value($id))!="Overflow!"){//获取可用ID
            $query = "select * from test_receipt where id = '$id'";
            $result = mysql_query($query);
            $RS = mysql_fetch_array($result);
        }
        else{
            $error='编号溢出！';
            break;
        }    
    }
    
    if($error=='')//插入入库单
    {
        $query = "insert test_receipt values ('$id', '$date', '$yewuyuan', '$type', '$company', '$warehouse', '$remark', '$itemstr')";
        $result = mysql_query($query);
    }
    
    //处理货品列表——————
    $list = explode('|',$itemstr);//print_r($list);
    foreach($list as $str){
        $info = explode('+',$str);//print_r($info);
        $item_id = $info[0];
        $item_num = $info[1];
        $item_price = $info[2];
        
        $inout_id = $date2."00";
        $query = "select * from test_inout where id = '$inout_id'";
        $result = mysql_query($query);
        $RS = mysql_fetch_array($result);
        while(!empty($RS)){
            if(($inout_id = next_value($inout_id))!="Overflow!"){//获取可用ID
                $query = "select * from test_inout where id = '$inout_id'";
                $result = mysql_query($query);
                $RS = mysql_fetch_array($result);
            }
            else{
                $error='编号溢出！';
                break;
            }    
        }
        if($error=='')//插入入库记录
        {
            $query = "insert test_inout values ('$inout_id', '$item_id', '$item_num', '$item_price', '$id', '$type')";
            $result = mysql_query($query);
        }
        
        $query = "select * from table_warehouse_$warehouse where id = '$item_id'";//更改仓库中相应货品数量
        $result = mysql_query($query );
        $RS = mysql_fetch_array($result);
        if(empty($RS)){//如果该仓库中之前没有此货品，则插入项目；否则更新项目
            $query = "insert table_warehouse_$warehouse values('$item_id' , $item_num )";//echo "<br>".$query."<br>";
            mysql_query($query);
        }
        else{
            $item_num = $RS[num] - $item_num;
            $query = "update table_warehouse_$warehouse set num = $item_num where id = '$item_id'";//echo "<br>".$query."<br>";
            mysql_query($query);
        }
    }
    
//    for($i=0;$i<$list.length;$i++){
//        $info = explode('+',$list[$i]);
//        $item_id = $info[0];
//        $item_num = $info[1];
//        $item_price = $info[2];
//        if(($result = mysql_query("select * from table_warehouse_$warehouse where id = '$item_id'"))==true){
//            $RS = mysql_fetch_array($result);
//            $item_num += $RS[num];
//            mysql_query("insert table_warehouse_$warehouse values('$item_id' , $item_num , $item_price)");
//        }
//    }
    mysql_close();
}

echo '<script language="javascript">';
echo 'var url;';

if($error=='')
{
    if($result == FALSE){
        echo "alert('添加失败！');";
        echo "var url = 'receipt_out.php';";
    }
    else{
        echo "alert('添加成功！');\n";
        echo "var url = 'receipt_out.php';";
    }
}
else
{
    echo "alert('$error');";
    echo "var url = 'receipt_out.php';";
}

echo 'location.href=url;';
echo '</script>'
?>