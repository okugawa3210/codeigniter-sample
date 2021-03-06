!function(root, scope) {
  'use strict';
  if (!root.jQuery) {
    throw new Exception('Unload to jQuery');
  }
  scope(root, jQuery);
}(window, function(root, $) {
  'use strict';
  $(function() {
    $(document)
      .on('click', '.tree .tree-expand', function() {
        var
          $target = $(this),
          $branche = $target.parents('.tree-branche');

        $branche.children('.tree').removeClass('hidden');
        $target.addClass('hidden');
        $branche.children('.tree-label').children('.tree-collapse').removeClass('hidden');
      })
      .on('click', '.tree .tree-collapse', function() {
        var
          $target = $(this),
          $branche = $target.parents('.tree-branche');

        $branche.children('.tree').addClass('hidden');
        $target.addClass('hidden');
        $branche.children('.tree-label').children('.tree-expand').removeClass('hidden');
      });
  });
});
