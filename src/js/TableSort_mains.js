
var IsAsc=true;

function SortTable(TableID,Col,DataType){ 
    
    IsAsc=!IsAsc; 
    var DTable=document.getElementById(TableID); 
    var DBody=DTable.tBodies[0]; 
    var DataRows=DBody.rows; 
    var MyArr=new Array; 
    for(var i=0;i<DataRows.length;i++){ 
        MyArr[i]=DataRows[i]; 
    } 
    //�ж��ϴ�������к�����Ƿ�Ϊͬһ�� 
    if(DBody.CurrentCol==Col){ 
        MyArr.reverse(); //�����鵹�� 
    } 
    else{ 
        MyArr.sort(CustomCompare(Col,DataType)); 
    } 
//����һ���ĵ���Ƭ�������е��ж���ӽ�ȥ���൱��һ���ݴ�ܣ�Ŀ���ǣ����ֱ�Ӽӵ�document.body���棬�����һ�У���ˢ��һ�Σ�������ݶ��˾ͻ�Ӱ���û����飩 
//�Ƚ���ȫ�������ݴ�����棬Ȼ���ݴ��������� һ����ӵ�document.body���������ֻ��ˢ��һ�Ρ� 
//������ȥ�̵깺�Ҫ�Ƚ�Ҫ�����Ʒ���У�ȫ��д�ڵ����ϣ��ĵ���Ƭ����Ȼ����ȫ�����򣬶������뵽һ��������ȥһ�Σ���ô 
    var frag=document.createDocumentFragment(); 
    for(var i=0;i<MyArr.length;i++){ 
        frag.appendChild(MyArr[i]); //�����������ȫ����ӵ��ĵ���Ƭ�� 
    } 
    DBody.appendChild(frag);//���ĵ���Ƭ�е���ȫ����ӵ� body�� 
    DBody.CurrentCol=Col; //��¼�µ�ǰ������� 
} 

//�Զ��������ʽ
function CustomCompare(Col,DataType){ 
    return function CompareTRs(TR1,TR2){ 
        var value1,value2; 
        //�ж��ǲ�����customvalue������� 
        if(TR1.cells[Col].getAttribute("customvalue")){ 
            value1=convert(TR1.cells[Col].getAttribute("customvalue"),DataType); 
            value2=convert(TR2.cells[Col].getAttribute("customvalue"),DataType); 
        } 
        else{ 
            value1=convert(TR1.cells[Col].firstChild.nodeValue,DataType); 
            value2=convert(TR2.cells[Col].firstChild.nodeValue,DataType); 
        } 
        if(value1 < value2) 
            return -1; 
        else if(value1 > value2) 
            return 1; 
        else 
            return 0; 
    }; 
} 
//��ʽת��
function convert(DataValue,DataType){ 
    switch(DataType){ 
        case "int": 
        return parseInt(DataValue); 
        case "float": 
        return parseFloat(DataValue); 
        case "date": 
        return new Date(Date.parse(DataValue)); 
        default: 
        return DataValue.toString(); 
    } 
} // JavaScript Document