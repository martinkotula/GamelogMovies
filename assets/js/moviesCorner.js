$(document).ready(function($) {
              
       $(".recent_review a").hover(function() {
       		$(this).stop().animate({paddingLeft : "10px"},200);
		},function() {
       $(this).stop().animate({paddingLeft : "0px"},200);

		});
	$('#comment').css('display',"block");       
	   zebra();
	   
	   $("#dialog").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 300,
			width: 500,
			modal: true,
			buttons: {
				'Zglos blad': function() {
					var reviewID = $("#postID").val();
					var comment = $("#comment").val();
		   $.ajax({			   
			   type: "post",
			   url: '../error_submit',
			   data: 'error_post='+reviewID+'&comment='+comment,			   
			   beforeSend: function(){$("#loading").show("fast");}, 			   
			   complete: function(){ $("#loading").hide("fast");}, 
			   success: function(){ 
				   $("#result").show("slow");				   
				   },			
			   }); },
		   
				Anuluj: function() {
					$(this).dialog('close');
				}			   
			},
			close: function() { 
				$('#result').hide(); 
				$('#comment').val('Co jest nie tak?');}
		});
		
	   
	   
	   $("#confirm").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 200,
			width: 300,
			modal: true,
			buttons: {
				'Tak': function() {
					var reviewID = $('[name="reviewID"]').val();
					$.post("../delete/"+reviewID, function() {
					window.location = "../../movies/details/"+$('[name="movieID"]').val();
					});
					$(this).dialog('close');
					},
		   
				'Nie': function() {
					
					$(this).dialog('close');
				}			   
			}
		});
		
	   $('#delete').click(function() {
		$('#confirm').dialog('open');
		return false;
	   });
	   
	   $('.error_report').click( function() {
		   var id = $(this).attr('id');
		   $('#postID').val(id);
		   $('#dialog').dialog('open');
		   return false;
	   });
	   
	$('.default-value').each(function() {

       var default_value = this.value;

       $(this).focus(function(){
               if(this.value == default_value) {
                       this.value = '';
               }
       });

       $(this).blur(function(){
               if(this.value == '') {
                       this.value = default_value;
               }
       });
	   
	});

	$('a.toggle').click( function() {
		var id = $(this).attr('id');
		$('.toggle-one').filter('div[id!=t_'+id+']').hide();
		$('#t_'+id).toggle("slow");
		return false;
	});
	
	
	$('input[type="image"]').mouseover(function(){
		$str = $(this).attr('src');
		$slashInd = $str.lastIndexOf('/');
		$file_name = $str.substring($slashInd+1);
		$file_name2 = 'r_'+$file_name;
		$str = $str.replace($file_name, $file_name2);
		$(this).attr('src', $str);
	});
	
	$('input[type="image"]').mouseout(function(){
		$str = $(this).attr('src');
		$slashInd = $str.lastIndexOf('/');
		$str2 = $str.substring(0,$slashInd+1);
		$str3 = $str.substring($slashInd+3);		
		$(this).attr('src', $str2 + $str3);
	});
});
	function zebra()
	{
		$('tr:odd').addClass('odd');
       $('tr:even').addClass('even');
	}
	
	