jQuery.noConflict();

(function ($) {
    var search = $('input#search');
    
    search.typeahead('destroy');
    search.typeahead({
      name: 'search',
      prefetch: 'components/com_holiness/assets/data/users.json',
      template: [
        '<div class="row-fluid">',
        '<div class="span2"><img src="/holliness/media/com_holiness/images/user-{{userid}}-icon.{{imgext}}" /></div>',
        '<div class="span10"><p><strong>{{name}}</strong></p><p><small>{{church}}</small></p></div>',
        '</div>'
      ].join(''),
      
      footer: '<hr style="margin: 10px 0px 5px 0px"><button class="btn btn-block btn-primary" type="button" style="margin-left: 2%; width: 96%;">See more results...</button>',
      
      engine: Hogan,

      limit: 10
    });
}(jQuery));
