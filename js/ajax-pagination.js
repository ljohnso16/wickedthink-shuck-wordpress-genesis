jQuery(document).ready(function($) {

	// The number of the next page to load (/page/x/).
	var pageNum = parseInt(passedvar.startPage) + 1;
	
	// The maximum number of pages the current query can return.
	var max = parseInt(passedvar.maxPages);
	
	// The link of the next page of posts.
	var nextLink = passedvar.nextLink;
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
	if(pageNum <= max) {
		$('#archived-projects-area').append('<div class="archived-projects-placeholder-'+ pageNum +'"></div>');
		$('#load-more-link').append('<p id="load-projects"><button class="btn btn-default" id="loadit">Load More Archived Projects</button></p>');	
	}
	$('#load-projects button').click(function() {
		// Are there more posts to load?
		if(pageNum <= max) {
			// Show that we're working.
			$(this).text('Loading posts...');
			
			$('.archived-projects-placeholder-'+ pageNum).load(nextLink + ' .archived-project',
				function() {
					// Update page number and nextLink.
					pageNum++;
					nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum); 					
					if(pageNum <= max) {
					// // Add a new placeholder, for when user clicks again.
					// Update the button message.
						$('#archived-projects-area').append('<div class="archived-projects-placeholder-'+ pageNum +'"></div>');
						$('#load-projects button').text('Load More Archived Projects');
					} else {
						$('#load-projects button').text('No more Projects.');
					}
				}
			);
		} else {
			$('#pbd-alp-load-posts a').append('.');
		}	
		
		return false;
	});
});