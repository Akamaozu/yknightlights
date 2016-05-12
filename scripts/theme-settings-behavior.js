jQuery( document ).ready( function($){
  
  // ACTIVATE IMAGE SELECTERS
    
    // logo image 
      create_image_uploader_instance( '#upload-button', 'Select Logo Image', 'Set as Logo', function( logo_url ){
            
        $('#image-url').val( logo_url );
        $('#logo-preview').attr( 'src', logo_url ).removeClass( 'hidden' );
      });
    
    // home card image
      create_image_uploader_instance( '#choose-home-card', 'Select Home Card Image', 'Set Image', function( image_url ){
            
        $('#home-card-url').val( image_url );
        $('#home-card-preview').attr( 'src', image_url ).removeClass( 'hidden' );
      });
    
    // search card image
      create_image_uploader_instance( '#choose-search-card', 'Select Search Card Image', 'Set Image', function( image_url ){
            
        $('#search-card-url').val( image_url );
        $('#search-card-preview').attr( 'src', image_url ).removeClass( 'hidden' );
      });

  function create_image_uploader_instance( trigger_query_selecter, title, btn_text, select_callback ){

    if( !trigger_query_selecter ) throw new Error( 'missing required field: "trigger_query_selecter"' );
    if( typeof trigger_query_selecter !== 'string' ) throw new Error( 'parameter "trigger_query_selecter" must be a string' );

    var trigger_element = $( trigger_query_selecter ),
        has_callback = typeof select_callback === "function",
        media_uploader;

    if( trigger_element.length < 1 ) return;

    trigger_element.click( function( e ){
      
      e.preventDefault();
      
      // If the uploader object has already been created, reopen the dialog
        if( media_uploader ) return media_uploader.open();
      
      // Configure wp.media object
        media_uploader = wp.media({
          
          title: title,
          
          button: {
            text: btn_text
          },
          
          library: {
            type: 'image' // display only image media-types
          },
          
          multiple: false
        });

       // set keys + values to be sent with image upload
        media_uploader.uploader.options.uploader.params = {
          'upload-source': 'theme-settings',
          'upload-type': 'image-only'
        };

      // When a file is selected, grab the URL and set it as the text field's value
        media_uploader.on('select', function() {
          
          var attachment = media_uploader.state().get('selection').first().toJSON();

          if( has_callback ) select_callback( attachment.url );
        });

      // Open the uploader dialog
        media_uploader.open();
    });
  }
});
