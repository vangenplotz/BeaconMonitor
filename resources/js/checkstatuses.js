(function($) {
  'use strict';

  $('.js-site').each(function(){
    var site = $(this),
        siteIndex = site.data('index'),
        siteUrl = site.data('url'),
        siteSecret = site.data('sitesecret'),
        versionElm = site.find('#js-siteversion-' + siteIndex),
        criticalVersionsElm = site.find('#js-criticalversions-' + siteIndex);

    if( siteUrl.substr(-1) != '/' ) {
      siteUrl += '/';
    }

    $.ajax({
      url: siteUrl + 'beacon/check',
      data: {
        siteSecret: siteSecret
      },
      dataType: 'json',
      crossdomain: true
    })
    .always(function() {
      site.attr('data-loading', false);
    })
    .success(function(data) {
      //console.log(data);
      versionElm.text(data.app.localVersion);
      criticalVersionsElm.html(data.app.criticalUpdateAvailable);
    });
  });

})(jQuery);