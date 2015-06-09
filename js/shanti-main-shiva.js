(function ($) {
		
  /**
   *  Front page tabs
   */
  Drupal.behaviors.shivaCustomGalleries = {
  	attach: function (context, settings) {
    	if(context == document) {
    			/**
    			 * Call wookmark script for custom shiva galleries:
    			 * 		.shanti-gallery2 => My Visualizations tab on home page
    			 * 		
    			 */
					$('.shanti-gallery2', context).imagesLoaded(function() {
		          // Prepare layout options.
		          var options = {
		          	align: 'left',
		            itemWidth: 160, // Optional min width of a grid item
		            autoResize: true, // This will auto-update the layout when the browser window is resized.
		            container: $('.shanti-gallery'), // Optional, used for some extra CSS styling
		            offset: 15, // Optional, the distance between grid items
		            outerOffset: 0, // Optional the distance from grid to parent
		            flexibleWidth: '30%', // Optional, the maximum width of a grid item
		            ignoreInactiveItems: false,
		          };
		          // Get a reference to your grid items.
		          var handler = $('.shanti-gallery li');
		
		          var $window = $(window);
		          $window.resize(function() {
		            var windowWidth = $window.width(),
		                newOptions = { flexibleWidth: '30%' };
		
		            // Breakpoint
		            if (windowWidth < 1024) {
		              newOptions.flexibleWidth = '100%';
		            }
		
		            handler.wookmark(newOptions);
		          });
		
		          // Call the layout function.
		          handler.wookmark(options);
		      });
		      
		      /**
		       * .sn-explore-list => the different accordion tabs on create/shivanode/all Create Page
		       */
		      $('.sn-explore-list', context).imagesLoaded(function() {
		          // Prepare layout options.
		          var options = {
		          	align: 'left',
		            itemWidth: 160, // Optional min width of a grid item
		            autoResize: true, // This will auto-update the layout when the browser window is resized.
		            container: $('.shanti-gallery'), // Optional, used for some extra CSS styling
		            offset: 15, // Optional, the distance between grid items
		            outerOffset: 0, // Optional the distance from grid to parent
		            flexibleWidth: '30%', // Optional, the maximum width of a grid item
		            ignoreInactiveItems: false
		          };
		          // Get a reference to your grid items.	
		          var handler = $('.sn-explore-list .shanti-thumbnail');
		
		          var $window = $(window);
		          $window.resize(function() {
		            var windowWidth = $window.width(),
		                newOptions = { flexibleWidth: '30%' };
		
		            // Breakpoint
		            if (windowWidth < 1024) {
		              newOptions.flexibleWidth = '100%';
		            }
		
		            handler.wookmark(newOptions);
		          });
		
		          // Call the layout function.
		          handler.wookmark(options);
		      }); 
			}
		}
	};
	
	

}(jQuery));