<?php
    include "../basic/database.php";
    include "../basic/include.php";
        
    $id = $_GET[id];
    if($id == '')
        die('ID未指定！');
    
    $query = "select * from test_exchange where id = '$id'";//echo $query."<br>";
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
    
    $query = "select name from table_warehouse where id = '$RS[warehouse2]'";//echo $query."<br>";
    $result_warehouse = mysql_query($query);
    $RS2 = mysql_fetch_array($result_warehouse);
    $warehouse2 = $RS2[name];
    

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>调拨单详细信息</title>
</head>
<style>
</style>
<!--<script type="text/javascript" src="../js/Calendar3.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="../style/style.css" >-->
<link rel="stylesheet" type="text/css" href="../css/iframe.css" media="screen" />
<script language="javascript">

</script>
<body style="width:800px">
<form id="item_in" name="item_in" method="post" action="../receipt_inout/receipt_in_bg.php" onsubmit=" return checkForm()">
  <h3>单据详情-调拨单</h3>
  <fieldset>
  <legend>单据信息</legend>
  <label>单据编号</label>
  <input id="id" name="id" type="text" value="<?php echo $id;?>" style="background-color:#CCCCCC" readonly/>
  <label>出货仓库</label>
  <select name="company" id="company" disabled>
    <?php echo "<option value='$RS[warehouse]'>$warehouse</option>";?>
  </select>
  <p>&nbsp;</p>
  <label>录单日期</label>
  <input name="date" id="date" type="text" value="<?php echo $date;?>" style="background-color:#CCCCCC" readonly/>
  <label>存货仓库</label>
  <select id="warehouse" name="warehouse" disabled>
    <?php echo "<option value='$RS[warehouse2]'>$warehouse2</option>";?>
  </select>
  <p>&nbsp;</p>
  <label>业务员</label>
  <input id="yewuyuan" name="yewuyuan" type="text" value="<?php echo $yewuyuan;?>" style="background-color:#CCCCCC" readonly/>
  
  </fieldset>
  <textarea name="item_str" id="item_str" style="display:none" hidden><?php echo $itemstr;?></textarea>
  <!--设定为隐藏域-->
  <fieldset>
  <legend>调拨列表</legend>
  <table id="item_list" border="1" width="100%" cellspacing="0" cellpadding="5" style="font-size:12px; border:thin; border-color:#9999FF ">
    <tr align="center">
      <td>货品编号</td>
      <td>名称</td>
      <td>规格型号</td>
      <td>单位</td>
      <td>数量</td>
    </tr>
    <?php
        $item_list = explode('|',$itemstr);//print_r($list);
        foreach($item_list as $str){
            echo '<tr align="center">';
            
            $item_info = explode('+',$str);//print_r($info);
            $item_id = $item_info[0];
            $item_num = $item_info[1];

            echo "<td>$item_id</td>";            
            if(1){
                $query = "select * from tb_product where encode = '$item_id'";
                $result_iteminfo = mysql_query($query);
                $RS2 = mysql_fetch_array($result_iteminfo);
                echo "<td>$RS2[name]</td>";
                echo "<td>$RS2[size]</td>";
                echo "<td>$RS2[unit]</td>";
            }
            else{
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
            }
            
            $total = number_format($item_num * $item_price,2);

            echo "<td>$item_num</td>";
            echo '</tr>';
        }
    ?>
  </table>
  <p>&nbsp;</p>
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