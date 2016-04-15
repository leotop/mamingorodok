$(function(){  
    function time(){
    return parseInt(new Date().getTime()/1000)
    }
    email = $(".adm-bus-table-container.caption.border.sale-order-props-group .adm-detail-content-cell-r input[name='PROPERTIES[5]']").val(); 
    $(".adm-bus-table-container.caption.border.sale-order-props-group .adm-detail-content-cell-r input[name='PROPERTIES[5]']").val(time()+'_'+email); 

})