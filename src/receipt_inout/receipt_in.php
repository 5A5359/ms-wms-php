<?php
//权限验证——
include("../const.php");
if ($authority[8]==0){  
    echo "<script language='javascript'>alert('对不起，你没有此操作权限！');history.back();</script>";
    exit;
}
//权限验证——

    include "../basic/include.php";
    include "../basic/database.php";
        
    $query = "select * from table_warehouse order by name";//echo $query."<br>";
    $result_warehouse = mysql_query($query);
    
    $query = "select * from table_company where type='供应商' order by name";
    $result_company = mysql_query($query);
    
    $query = "select * from tb_inout where type='入库' order by name";
    $result_inout = mysql_query($query);
    mysql_close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>货品入库</title>
</head>
<style>
</style>
<script type="text/javascript" src="../js/Calendar3.js"></script>
<!--<link rel="stylesheet" type="text/css" href="../style/style.css" >-->
<link rel="stylesheet" type="text/css" href="../css/iframe.css" media="screen" />
<script language="javascript">
var MAX = 10;
//表单检查
function checkForm(){//在提交表单之前检查整个表单输入，存在错误则不提交
    /*var element = document.getElementById('id');
    if(element.value==''){
        alert('单据编号不能为空！');
        element.focus();
        return false;
    }*/
    element = document.getElementById('control_date');//检查日期
    if(element.value==''||element.value=='单击选择日期'){
        alert('录单日期不能为空！');
        element.focus();
        return false;
    }
    element = document.getElementById('yewuyuan');//检查业务员
    if(element.value==''){
        alert('业务员不能为空！');
        element.focus();
        return false;
    }
    element = document.getElementById('item_str');//检查货品
    if(element.value==''){
        alert('表单中货品不能为空！');
        //element.focus();
        return false;
    }
    return true;
}
function selectitem(){//选择对象
    //var url = 'item_choose.php';
    var url = '../product/showproduct.php?stype=1&mtype=1';
    window.open(url,'_blank','directorys=no,toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=853,height=470,top=176,left=161');
}
function checkInput(){//检查：货品是否已存在；单价是否规范；数量是否规范，是否超出最大库存量等。
    var table = document.getElementById('item_list');
    var length = table.rows.length;
    
    var item_id = document.getElementById('item_id').value;//检查货品ID
    if(item_id == '单击选择货品'){//如果没有选择货品
        alert('请单击选择货品！');
        return false;
    }
    var item_num = document.getElementById('item_num');//检查数量
    if(item_num.value == ''){
        alert('货品数量不能为空！');
        item_num.focus();
        return false;
    }
    var item_price = document.getElementById('item_price');//检查价格
    if(item_price.value == ''){
        alert('货品价格不能为空！');
        item_price.focus();
        return false;
    }
    for(var i=1;i<length;i++)
        if(item_id == table.rows[i].firstChild.innerHTML){//如果选择的货品已存在
            if(confirm('选择的货品已存在，如果继续添加将会覆盖原信息！')==true){
                if(editRow2()==true){
                    updateStr();
                    return false;//修改信息成功，则不添加新的行，否则按添加新行处理
                }
                else{
                    return true;
                }
            }
            else return false;
        }
    //其它检查项目
    
    return true;
}
function addRow(){//在表格中添加一行
    var table = document.getElementById('item_list');
    var pos = table.rows.length;
    if(pos >= MAX+1){
        alert('货品项目已达到最大值：MAX = ' + MAX);
        return false;
    }
    var tr = table.insertRow(pos);
    tr.align = 'center';
    var td0 = tr.insertCell(0);
    var td1 = tr.insertCell(1);
    var td2 = tr.insertCell(2);
    var td3 = tr.insertCell(3);
    var td4 = tr.insertCell(4);
    var td5 = tr.insertCell(5);
    var td6 = tr.insertCell(6);
    var td7 = tr.insertCell(7);
    var td8 = tr.insertCell(8);
    td0.innerHTML = document.getElementById('item_id').value;
    td1.innerHTML = document.getElementById('item_name').value;
    td2.innerHTML = document.getElementById('item_model').value;
    td3.innerHTML = document.getElementById('item_unit').value;
    td4.innerHTML = document.getElementById('item_num').value;
    td5.innerHTML = document.getElementById('item_price').value;
    var price = document.getElementById('item_num').value*document.getElementById('item_price').value;
    var price_str = price.toFixed(2);
    td6.innerHTML = price_str;
    td7.innerHTML = '<a onclick="removeRow(this)">删除</a>';
    td8.innerHTML = '<a onclick="editRow(this)">修改</a>';
    updateStr();//更新隐藏域的值
    //resetInput()//恢复默认的编辑框
    
}
function updateStr(){//更新隐藏域的值
    var item_str = document.getElementById('item_str');
    var table = document.getElementById('item_list');
    var i,j;
    var str = '';
    var item_array = new Array(3);
    var item_info;
    var list_array = new Array(table.rows.length-1);
    for(i=1;i<table.rows.length;i++){
        item_array[0] = table.rows[i].cells[0].innerHTML;
        item_array[1] = table.rows[i].cells[4].innerHTML;
        item_array[2] = table.rows[i].cells[5].innerHTML;
        item_info = item_array.join('+');
        list_array[i-1] = item_info;
    }
    str = list_array.join('|');
//    for(i=1;i<table.rows.length;i++){
//        str += '|' + table.rows[i].cells[0].innerHTML;
//        str += '&' + table.rows[i].cells[4].innerHTML;
//        str += '&' + table.rows[i].cells[5].innerHTML;
//    }
    item_str.value = str;
    alert(item_str.value);
    resetInput()
}
function removeRow(button){//删除该行
    var tr = button.parentNode.parentNode;
    var table = tr.parentNode;
     table.deleteRow(tr.rowIndex);
    updateStr();
}
function editRow(button){//修改该行信息，将该行的值赋给编辑域
    var tr = button.parentNode.parentNode;
    document.getElementById('item_id').value = tr.cells[0].innerHTML;
    document.getElementById('item_name').value = tr.cells[1].innerHTML;
    document.getElementById('item_model').value = tr.cells[2].innerHTML;
    document.getElementById('item_unit').value = tr.cells[3].innerHTML;
    document.getElementById('item_num').value = tr.cells[4].innerHTML;
    document.getElementById('item_price').value = tr.cells[5].innerHTML;
}
function editRow2(){//修改该行信息，将编辑域的值覆盖原有的值
    var table = document.getElementById('item_list');
    var length = table.rows.length;
    var pos = 0;
    for(var i=0;i<length;i++)
        if(table.rows[i].cells[0].innerHTML == document.getElementById('item_id').value)
            pos = i;
            
    if(pos == 0){
        alert('出错！没有找到对应的行！将添加新的行！');
        return false;
    }
    else{
        var tr = table.rows[pos];
        tr.cells[0].innerHTML = document.getElementById('item_id').value
        tr.cells[1].innerHTML = document.getElementById('item_name').value
        tr.cells[2].innerHTML = document.getElementById('item_model').value
        tr.cells[3].innerHTML = document.getElementById('item_unit').value
        tr.cells[4].innerHTML = document.getElementById('item_num').value
        tr.cells[5].innerHTML = document.getElementById('item_price').value
        var price = document.getElementById('item_num').value * document.getElementById('item_price').value;
        var price_str = price.toFixed(2);
        tr.cells[6].innerHTML = price_str;
        return true;
    }
}
function resetInput(){//提交输入后，将输入框字符设为默认（建议内嵌于updateStr中）
    document.getElementById('item_id').value = "单击选择货品";
    document.getElementById('item_name').value = "";
    document.getElementById('item_model').value = "";
    document.getElementById('item_unit').value = "";
    document.getElementById('item_num').value = "";
    document.getElementById('item_price').value = "";
}
function valueLimit(input){
    var str = input.value;
    var list = str.split('.');
    if(list.length>2)
        input.value = list[0] + '.' + list[1];
    else if(list.length==2){
        if(list[0]=='') list[0] = '0';
        if(list[1].length>2) list[1] = list[1].substring(0,2);
        input.value = list[0] + '.' + list[1];
    }
    else if(list[0].length>5){
        input.value = list[0].substring(0,5);
    }
}
</script>
<body style="width:800px">
<form id="item_in" name="item_in" method="post" action="receipt_in_bg.php" onsubmit=" return checkForm()">
  <h3>货品入库</h3>
  <fieldset>
  <legend>单据信息</legend>
  <label>单据编号</label>
  <input id="id" name="id" type="text" onkeyup="value=value.replace(/[^\d]/g,'')" style="background-color:#CCCCCC" readonly/>
  <label>供应商</label>
  <select name="company" id="company">
    <?php while($RS = mysql_fetch_array($result_company))echo "<option value=$RS[id]>$RS[name]</option>";    ?>
  </select>
  <p><a href="/wms/basic/company/company_show.php" target="_self"><img src="/wms/image/delete.gif" alt="往来公司管理" width="25" height="19" border="0"/></a></p>
  <label>录单日期</label>
  <input name="date" type="text" id="control_date" style="background-color:#CCCCCC" onclick="new Calendar().show(this);"  maxlength="10" readonly/>
  <label>存货仓库</label>
  <select id="warehouse" name="warehouse">
    <?php while($RS = mysql_fetch_array($result_warehouse))echo "<option value=$RS[id]>$RS[name]</option>";?>
  </select>
  <p><a href="/wms/basic/warehouse/warehouse_show.php" target="_self"><img src="/wms/image/delete.gif" alt="仓库管理" width="25" height="19" border="0"/></a></p>
  <label>业务员</label>
  <input id="yewuyuan" name="yewuyuan" type="text" />
  <label>入库类型</label>
  <select id="type" name="type">
    <?php while($RS = mysql_fetch_array($result_inout))echo "<option value=$RS[id]>$RS[name]</option>";?>
  </select>
  <p><a href="../test/_self" target="_self"><img src="/wms/image/delete.gif" alt="出入库类型管理" width="25" height="19" border="0"/></a></p>
  </fieldset>
  <input name="item_str" id="item_str" style="display:none" hidden/>
  <!--设定为隐藏域-->
  <fieldset>
  <legend>货品列表</legend>
  <table id="item_list" width="60%" border="1" cellspacing="0" cellpadding="5" style="font-size:12px; border:thin; border-color:#9999FF ">
    <tr align="center">
      <td>编号</td>
      <td>名称</td>
      <td>规格型号</td>
      <td>单位</td>
      <td>数量</td>
      <td>单价</td>
      <td>小计</td>
      <td>删除</td>
      <td>修改</td>
    </tr>
  </table>
  </fieldset>
  <fieldset>
  <legend>添加货品</legend>
  <label>编号</label>
  <input id="item_id" name="item_id" type="text" onclick="selectitem()" value="单击选择货品" size="10" style="background-color:#CCCCCC" readonly />
  <label>名称</label>
  <input id="item_name" name="item_name" type="text" size="5" style="background-color:#CCCCCC" readonly />
  <label>规格</label>
  <input id="item_model" name="item_model" type="text" size="5" style="background-color:#CCCCCC" readonly />
  <label>单位</label>
  <input id="item_unit" name="item_unit" type="text" size="5" style="background-color:#CCCCCC" readonly />
  <p>&nbsp;</p>
  <label>数量</label>
  <input name="item_num" type="text" id="item_num" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="4" />
  <!--onchange="valueLimit(this)"-->
  <label>单价</label>
  <input name="item_price" type="text" id="item_price" onkeyup="value=value.replace(/[^.\d]/g,'');valueLimit(this)" maxlength="8" />
  <button type="button" onclick="if(checkInput()==true) addRow();">&nbsp;添加&nbsp;</button>
  </fieldset>
  <fieldset>
  <legend>其它</legend>
  <label>备注</label>
  <textarea name="remark" cols="15" rows="3" onkeyup="if(this.innerHTML.length>50) this.innerHTML=this.innerHTML.substr(0,50)"></textarea>
  <button type="submit" style="margin-left:50px">&nbsp;提交表单&nbsp;</button>
  </fieldset>
</form>
<p><a href="../basic/company/company_show.php">返回上一页</a></p>
</body>
</html>
