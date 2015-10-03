!function(root, scope) {
  'use strict';
  if (!root.jQuery) {
    throw new Exception('Unload to jQuery');
  }
  scope(root, jQuery);
}(window, function(root, $) {
  'use strict';

  $(function() {
    $('.top h1').on('click', function() {
      alert('why click me ?');
    });
  });
});
