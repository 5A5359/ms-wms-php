<?php
    $id = $_GET[id];
    if($id == '')
        die('ID未指定！');
    
    $con = mysql_connect("localhost","root","1234");
    mysql_select_db("ms_wms_php", $con);
    mysql_query("set names utf8 ");
    
    $query = "select * from test_receipt where id = '$id'";//echo $query."<br>";
    $result = mysql_query($query);
    $RS = mysql_fetch_array($result);
    if(empty($RS))
        die('未找到指定项目！');
    $date = $RS[date];
    $yewuyuan = $RS[yewuyuan];
    $itemstr = $RS[itemstring];
    $remark = $RS[remark];
    
    
    $query = "select name from table_warehouse where id = '$RS[warehouse]'";//echo $query."<br>";
    $result_warehouse = mysql_query($query);
    $RS2 = mysql_fetch_array($result_warehouse);
    $warehouse = $RS2[name];
    
    $query = "select name from table_company where id = '$RS[company]'";//echo $query."<br>";
    $result_company = mysql_query($query);
    $RS2 = mysql_fetch_array($result_company);
    $company = $RS2[name];
    
    $query = "select name from tb_inout where id = $RS[type]";//echo $query."<br>";
    $result_inout = mysql_query($query);
    $RS2 = mysql_fetch_array($result_inout);
    $type = $RS2[name];
    

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>出入库单据详细信息</title>
</head>
<style>
</style>
<!--<script type="text/javascript" src="../js/Calendar3.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="../style/style.css" >-->
<link rel="stylesheet" type="text/css" href="../css/iframe.css" media="screen" />
<script language="javascript">
</script>
<body>
<form id="item_in" name="item_in" method="post" action="../test/receipt_in_bg.php" onsubmit=" return checkForm()">
  <h3>单据详情</h3>
  <fieldset>
  <legend>单据信息</legend>
  <label>单据编号</label>
  <input id="id" name="id" type="text" value="<?php echo $id;?>" style="background-color:#CCCCCC" readonly/>
  <label>供应商</label>
  <select name="company" id="company" disabled>
    <?php echo "<option value='$RS[company]'>$company</option>";?>
  </select>
  <p>&nbsp;</p>
  <label>录单日期</label>
  <input name="date" id="date" type="text" value="<?php echo $date;?>" style="background-color:#CCCCCC" readonly/>
  <label>存货仓库</label>
  <select id="warehouse" name="warehouse" disabled>
    <?php echo "<option value='$RS[warehouse]'>$warehouse</option>";?>
  </select>
  <p>&nbsp;</p>
  <label>业务员</label>
  <input id="yewuyuan" name="yewuyuan" type="text" value="<?php echo $yewuyuan;?>" style="background-color:#CCCCCC" readonly/>
  <label>入库类型</label>
  <select id="type" name="type" disabled>
    <?php echo "<option value='$RS[type]'>$type</option>";?>
  </select>
  </fieldset>
  <textarea name="item_str" id="item_str" hidden><?php echo $itemstr;?></textarea>
  <!--设定为隐藏域-->
  <fieldset>
  <legend>货品列表</legend>
  <table id="item_list" border="1" width="100%" cellspacing="0" cellpadding="5" style="font-size:12px; border:thin; border-color:#9999FF ">
    <tr align="center">
      <td>编号</td>
      <td>名称</td>
      <td>规格型号</td>
      <td>单位</td>
      <td>数量</td>
      <td>单价</td>
      <td>小计</td>
    </tr>
    <?php
        $item_list = explode('|',$itemstr);//print_r($list);
        $sum = 0.00;
        foreach($item_list as $str){
            echo '<tr align="center">';
            
            $item_info = explode('+',$str);//print_r($info);
            $item_id = $item_info[0];
            $item_num = $item_info[1];
            $item_price = number_format($item_info[2],2);
            
            if(0){
                $query = "select * from tb_iteminfo where id = '$item_id'";
                $result = mysql_query($query);
                $RS = mysql_fetch_array($result);        
                $item_name = $RS[name];
                $item_model = $RS[model];
                $item_unit = $RS[unit];
            }
            $total = number_format($item_num * $item_price,2);
            
            echo "<td>$item_id</td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td>$item_num</td>";
            echo "<td>$item_price</td>";
            echo "<td>$total</td>";    
            echo '</tr>';
            $sum = $sum + $item_num * $item_price;
        }
        $sum_str = number_format($sum,2);
    ?>
  </table>
  <p>&nbsp;</p>
  <label>总计：</label><label><?php echo $sum_str;?></label> 
  </fieldset>
  <fieldset>
  <legend>其它</legend>
  <label>备注</label>
  <textarea name="remark" cols="15" rows="3" disabled><?php echo $remark;?></textarea>
  </fieldset>
</form>
</body>
</html>
<?php
mysql_close();
?>