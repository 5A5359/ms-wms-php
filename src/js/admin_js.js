// JavaScript Document
//��¼ҳ����֤
function check(){
    if(login.username.value==""){
        alert("�������û���!!");
        login.username.focus();
        return false;        
    }
    if(login.pwd.value==""){
        alert("����������!!");
        login.pwd.focus();
        return false;
    }
}
//left�����˵�
function clickList() {
  var targetId, srcElement, targetElement;
  srcElement = window.event.srcElement;
  if (srcElement.className == "active") {
     targetId = srcElement.id + "other"; 
     targetElement = document.all(targetId);
     if (targetElement.style.display == "none") {
        targetElement.style.display = "";
     } else {
        targetElement.style.display = "none";
     }
  }
}
//��Ӳ���ҳ����֤
function a_check(){
    if(    document.a_depart.d_name.value == ""){
            alert("�����벿������");
            document.a_depart.d_name.focus();
            return false;
        }
}
//��̬�����˵�
function ShowTR(objImg,objTr)
{
    if(objTr.style.display == "block")
    {
        objTr.style.display = "none";
        objImg.src="../Images/jia.gif";
        objImg.alt = "չ��";        
    }
    else
    {
        objTr.style.display = "block";
        objImg.src="../Images/jian.gif";
        objImg.alt = "�۵�";        
    }
}
//ɾ��ȷ��
function cfm(){
    if(confirm('ȷ��Ҫɾ��������'))
        return true;
    else
        return false;
}
//ְԱ��ѯ
function chk_null(){
    if(document.found.u_key.value == ""){
     alert("��������ؼ���");
     return false;
    } 
}
//ɾ��ְԱ
function del_chk(){
    if(confirm('ȷ��Ҫɾ����'))
        return true;
    else
        return false;
}
//���ְԱ��Ϣ
function add_check(){
    var das = document.add_staf;
    if(das.u_user.value == ""){
        alert("�˺Ų�����Ϊ��");
        return false;
    }
    if(das.u_name.value == ""){
        alert("����������Ϊ��");
        return false;
    }
    if(das.u_pwd.value == ""){
        alert("���벻����Ϊ��");
        return false;
    }
}
//�޸�Ա����Ϣ
function mod_check(){
    var das = document.mod_staf;
    if(das.u_user.value == ""){
        alert("�˺Ų�����Ϊ��");
        return false;
    }
    if(das.u_name.value == ""){
        alert("����������Ϊ��");
        return false;
    }
}

function glist(){
    var len = document.form1.right.length;
    var list = "";
    if(form1.u_group.value == ""){
        alert("�û������Ʋ���Ϊ��");
        return false;
    }
    for(var i = 0; i < len; i++){
        list += document.form1.right[i].text + ",";
    }
    form1.g_list.value = list;
}
function glist1(){
    var len = document.form1.right.length;
    var list = "";
    for(var i = 0; i < len; i++){
        list += document.form1.right[i].text + ",";
    }
    form1.g_list.value = list;
}

//�ƶ�select�Ĳ�������,�������value���˺�����valueΪ��׼�����ƶ�
function moveSelected(oSourceSel,oTargetSel)
{
     var arrSelValue = new Array();
     var arrSelText = new Array();
     var arrValueTextRelation = new Array();
     var index = 0;
     for(var i=0; i<oSourceSel.options.length; i++)
     {
         if(oSourceSel.options[i].selected)
         {

             arrSelValue[index] = oSourceSel.options[i].value;
             arrSelText[index] = oSourceSel.options[i].text;
             arrValueTextRelation[arrSelValue[index]] = oSourceSel.options[i];
             index ++;
         }
     }
     for(var i=0; i<arrSelText.length; i++)  
     {
         var oOption = document.createElement("option");
         oOption.text = arrSelText[i];
         oOption.value = arrSelValue[i];
         oTargetSel.add(oOption);
         oSourceSel.removeChild(arrValueTextRelation[arrSelValue[i]]);
     }
 }
 //ɾ��
function chk_del(){
    if(confirm("ȷ��Ҫɾ��ѡ�е���Ŀ��һ��ɾ�������ָܻ���"))
        return true;
    else
        return false;
}
//�޸Ĺ���Ա����
function mod_chk(){
    var dmp = document.mod_pwd;
    if(dmp.old_pwd.value == "" || dmp.new_pwd.value == "" || dmp.two_pwd.value == ""){
        alert("���������Ϊ��");
        return false;
    }
    if(dmp.new_pwd.value != dmp.two_pwd.value){
        alert("�������벻һ��");
        return false;
    }
}
//ɾ������
function del_bak(){
if(confirm("ȷ��Ҫɾ�������ļ���һ��ɾ�������ָܻ���"))
        return true;
    else
        return false;
}
//�ָ�����
function re_bak(){
    if(document.rebak.r_name.value == ""){
        alert("��ʱû�оɵı����ļ�");
        return false;
    }
    if(confirm("ȷ��Ҫ�ָ�������"))
        return true;
    else
        return false;
}