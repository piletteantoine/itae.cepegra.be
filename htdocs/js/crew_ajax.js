$.getJSON('content.json',function(data){
	$.each(data, function(entryIndex, entry){
		var html = '<article class="thumbnail">';
			html += '<figure>';
			html += '<img src="images/crew/'+ entry['id'] +'.png"/>';
			html += '<h3>' + entry['name']+ '</h3>';
			html += '<div class="toggle-control" style="display:block!important; font-size: 1.5em;" onclick="classList.toggle(\'more\');">' + '</div>';
			html += '</figure>';
			html += '<div id="'+ entry['born'] +'">' + '<div id="'+ entry['dead'] +'">' + '<p>' + entry['comment'] + '</p>' + '<blockquote>' + entry['anecdote'] + '</blockquote>' + '<p class="function">' + "Role: " + entry['function'] + '</p>' + '</div>' + '</div>';
			html += '</article>';
		$('.the_crew').append(html);

			$(document).ready(function(){
				$('.thumbnail div').css({'display': 'none'});
				$(".toggle-control").click(function(){
				$(".thumbnail div").show();
				$('.the_crew figure').css({'width': '100%'});
			});
			$(".more").click(function(){
				$(".thumbnail div").hide(1000);
				$('.thumbnail div').css({'display': 'none'});
			});
		});
	});
});