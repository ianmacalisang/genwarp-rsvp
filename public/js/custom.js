$(document).ready(function(){
	
	$('#guestSubmit').on('submit', function(){
    	$('#submitButton').prop('disabled', true).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Please wait...');
    	console.log('processing...');
	});
	
	$('#cardSubmit').on('submit', function(){
    	$('#cardButton').prop('disabled', true).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Please wait...');
    	console.log('processing...');
	});
  
   	     		
});