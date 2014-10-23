$( document ).ready(function(){

	$(' #left_nav').find('> ul > li').each(function(){
		var $this = $(this);

		if( $this.find('ul').length > 0 )
		{
			var $a_tag = $this.children('a');

			$a_tag.text( $a_tag.text() + ' +' );

			$a_tag.click(function(event){
				$a_tag.parent().find('ul').toggle(200);
			});
		}
	});

	$(' #left_nav').find('a').click(function(){
		var $this = $(this);
		$('section').find( '.page' ).hide(100);
		$('section').find( $this.attr('href') ).show(200);
	});


	var $query = window.location.href;
	if( $query.search('#') != -1 )
	{
		$('section').find( '.page' ).hide(100);
		$('section').find( '#' + $query.split('#')[1] ).show(200);	
	}

});