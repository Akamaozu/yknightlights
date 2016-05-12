jQuery( document ).ready( function($){

  var mediaUploader;

  $('#upload-button').click( function(e) {
    
    e.preventDefault();
    
    // If the uploader object has already been created, reopen the dialog
      if( mediaUploader ) return mediaUploader.open();
    
    // Configure wp.media object
      mediaUploader = wp.media({
        
        title: 'Select Logo Image',
        button: {
          text: 'Set as Logo'
        },
        library: {
          type: 'image' // display only image media-types
        },
        multiple: false
      });

     // set keys + values to be sent with image upload
      mediaUploader.uploader.options.uploader.params = {
        'upload-source': 'theme-settings',
        'upload-type': 'logo-image'
      };

    // When a file is selected, grab the URL and set it as the text field's value
      mediaUploader.on('select', function() {
        
        var attachment = mediaUploader.state().get('selection').first().toJSON();
        $('#image-url').val( attachment.url );
      });

    // Open the uploader dialog
      mediaUploader.open();
  });
});