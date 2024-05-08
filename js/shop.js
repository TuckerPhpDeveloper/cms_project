function shop_save()
{

 jQuery("#basicForm").validate({

					
					rules: {
							sname: {
							minlength: 2,
							required: true
						},
						sno: {
					
							required: true
						},
						contact: {
					
							required: true
						},
						mobile: {
							digits:true,
							required: true
						},
						email: {
							email:true
							
						}
						
						
					},

	
		
    highlight: function(element) {
      $(element)	.closest('.help-inline').removeClass('ok');
	  jQuery(element).closest('.control-group').removeClass('has-success').addClass('has-error');
    },
	unhighlight: function (element) { // revert the change dony by hightlight
			
				jQuery(element).closest('.control-group').removeClass('has-error');
			},

    success: function(element) {
     
	  jQuery(element).addClass('valid').addClass('help-inline ok') 

	 jQuery(element).closest('.control-group').removeClass('has-error');
	
	

	
	},
		submitHandler: function (form) {

					 $.ajax({
									 url: "shop_save.php", 
									 dataType: "html",
									 type: 'POST', 
									 data: $('#basicForm').serialize(),
									 success: function(retval){ 
										
										
												
												$("#success").removeClass('alert-error');

												$("#success").removeClass('alert-success hide');
																							
												
												if(retval==1)
													{
																										
																										
													$("#success").addClass('alert-success');

													$("#success").html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Shop Details!</strong> has been saved <a href='#' class='alert-link'> successfully</a>");
												
													$("#basicForm").trigger('reset');
													
													}
													else if(retval==2)
													{


													
													$("#success").addClass('alert-success');

													
													$("#success").html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Shop Details!</strong> has been updated <a href='#' class='alert-link'> successfully</a>");

													location.href="shoplist.php";

													
													}
													else
													{
													
													

													$("#success").addClass('alert-danger');

													$("#success").html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Shop Details!</strong> already exists.</a>");
													
													}



									 }
					
					  
						});
										
		
		}
  });
  

}


function delete_material(id)
{

			
			total_val=$("#total_mid").val();

			
			
			data_split=total_val.split("@@@");

			len=data_split.length;

			
			total_data="";

			total_count=0;
			
			for(i=0;i<len-1;i++)
			{
			
			cbox_prefix="cbox_"+data_split[i];

			if($("#"+cbox_prefix).prop('checked') == true){
						
				
				total_data=total_data+data_split[i]+"@@@";

				total_count++;
					
			}
			
			
			
			
			}

			if(total_data!="")
				{
			
			
			
				
								bootbox.confirm("<span style='font-weight:bold;'>Are you sure? You want to delete this <span style='font-weight:bold;background-color:#D9534F;' class='badge badge-important' >"+total_count+"</span> Shop Details</span>", function(result) {
														
														if(result==true)
														{
														
														
														
																	 $.ajax({
																							 url: "deleteshop.php?val="+total_data, 
																							 dataType: "html",
																							 type: 'POST', 
																							 //data: $('#frm_addmaterial').serialize(),
																							 success: function(retval){ 
																								
																									
																									bootbox.alert("<span style='font-weight:bold;'>Shop Details Deleted Successfully..</span>");										
																						
																									
																									location.href="shoplist.php";
																								

																							 }
																			
																			  
																				});
														
														
														
														
														}
														
														
														
														}); 	
														

							
				}
				else
				{
				
				bootbox.alert("<span style='font-weight:bold;'>Please Select Atleast one checkbox..</span>");		
				
				
				return false;
				
				}

		


}