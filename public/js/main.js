(function() {
    var trumbowyg = {
        lang: 'ru',
        semantic: false,
        removeformatPasted: true,
        btnsDef: {
          align: {
            dropdown: ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ico: 'justifyLeft'
          },
          lists: {
            dropdown: ['unorderedList', 'orderedList'],
            ico: 'unorderedList'
          },
          styles: {
            dropdown: ['strong', 'em', 'del', 'underline'],
            ico: 'strong'
          },
          scripts: {
            dropdown: ['superscript', 'subscript'],
            ico: 'superscript'
          },
          image: {
            dropdown: ['insertImage', 'upload'],
            ico: 'insertImage'
          }
        },
        btns: [
          ['viewHTML'],
          ['formatting'],
          ['styles'],
          ['link'],
          ['scripts'],
          ['align'],
          ['lists'],
//          ['foreColor', 'backColor'],
          ['image'],
          ['table'],
          ['horizontalRule'],
          ['removeformat']
        ],
        plugins: {
          upload: {
            serverPath: 'https://api.imgur.com/3/image',
            fileFieldName: 'image',
            headers: {
              'Authorization': 'Client-ID 1c0c53041cfcaa8'
            },
            urlPropertyName: 'data.link'
          }
        }
    };
    
    $('#content').trumbowyg(trumbowyg);
    
    // Close notification message
    $('button.close').on('click', function() {
        $(this).parent().slideUp(300);
    });
    
    // Autohide notifications after 5 sec delay
    setTimeout(function() {
        $('button.close').parent().slideUp(300);
    }, 5000);
    
    $('.nav-tabs a').on('click', function(e) {
        e.preventDefault();
        var $tabsContainer = $(this).closest('.nav-tabs').siblings('.tab-content');
        $(this).closest('.nav-tabs').find('li').removeClass('active');
        $(this).parent().addClass('active');
        $tabsContainer.children().css({ visibility: 'hidden' });
        $tabsContainer.find($(this).attr('href')).css({ visibility: 'visible' });
    });
    
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
})();
