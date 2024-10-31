//////////////
jQuery(document).ready(function(){
    jQuery('#racart_deleteall').on('click',function(){
         var lengthdd = jQuery('.checkbox:checked').length;
         if(lengthdd==0){
            var result = confirm("Please select checkbox which you want to delete.");
            if(result){
                return false;
            }else{
                return false;
            }
         }else{
            var result = confirm("Do you really want to delete records?");
            if(result){
                return true;
            }else{
                return false;
            }
        }
    });
});
jQuery(document).ready(function(){
    jQuery('#check_all').on('click',function(){
        if(this.checked){
            jQuery('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
            jQuery('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    jQuery('.checkbox').on('click',function(){
        if(jQuery('.checkbox:checked').length == jQuery('.checkbox').length){
            jQuery('#check_all').prop('checked',true);
            
        }else{
            jQuery('#check_all').prop('checked',false);
        }
    });
});
jQuery(document).ready(function () {
    var container_onload = jQuery('#racart_cron_emailchange').val();
    if(container_onload==0){
        jQuery('#racart_cron_enable_disable').hide();
    }else{
        jQuery('#racart_cron_enable_disable').show();
    }
    jQuery('#racart_cron_emailchange').on('change', function (event) {
    var container1 = jQuery('#racart_cron_emailchange').val();
        if(container1==1){
            jQuery('#racart_cron_enable_disable').show();
        }else{
            jQuery('#racart_cron_enable_disable').hide();
        }
    });
});