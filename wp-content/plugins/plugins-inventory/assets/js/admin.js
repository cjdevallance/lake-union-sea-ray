jQuery(document).ready(function() {
    PostData();
});

function PostData(){

    jQuery('#inventory-content').hide();
    jQuery('#loading-content').show();
    jQuery('#loading-content').html('<img src="../wp-content/plugins/plugins-inventory/images/ajax-loader.gif">');

    jQuery.ajax({
        type: "POST",
        url: "../wp-content/plugins/plugins-inventory/inc/inventory-front.php",
        dataType:"text",
        success: function(data) {
            jQuery('#loading-content').hide();
            jQuery('#inventory-content').show();
            jQuery('#inventory-content').html(data);

        },
        error:function (xhr, ajaxOptions, thrownError){
            //On error, alert user
            console.log(thrownError);
        }
    });

}

jQuery(document).ready(function() {
    jQuery("body").on("click", ".del_button", function(e) {
        e.preventDefault();
        var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var DbNumberID = clickedID[1]; //and get number from array
        var myData = 'recordToDelete='+ DbNumberID; //build a post data structure

        jQuery('#item_'+DbNumberID).addClass( "sel" ); //change background of this element by adding class
        jQuery('#inventory-content').hide(); //hide currently clicked delete button
        jQuery('#loading-content').show();
        jQuery('#loading-content').html('<img src="../wp-content/plugins/plugins-inventory/images/ajax-loader.gif">');

        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "../wp-content/plugins/plugins-inventory/inc/inventory-front.php", //Where to make Ajax calls
            dataType:"text", // Data type, HTML, json etc.
            data:myData, //Form variables
            success:function(response){
                //on success, hide  element user wants to delete.
                jQuery('#item_'+DbNumberID).fadeOut();
                PostData();
            },
            error:function (xhr, ajaxOptions, thrownError){
                //On error, alert user
                console.log(thrownError);
            }
        });

    });

});

jQuery(document).ready(function() {
    jQuery('#select_all').click(function(event) {  //on click 
        if(this.checked) { // check select status
            jQuery('.makecheck').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "makecheck"
            });
        }else{
            jQuery('.makecheck').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "makecheck"
            });
        }
    });

});
