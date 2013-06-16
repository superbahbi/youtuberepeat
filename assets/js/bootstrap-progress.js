/* ==========================================================
 * bootstrap-progress.js v2.0.0
 * http://twitter.github.com/bootstrap/javascript.html#progress-bars
 * ==========================================================
 * Copyright 2011 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function( $ ){

  "use strict"

 /* PROGRESS BAR CLASS DEFINITION
  * ====================== */

  var selector = '[data-progress]',
      ProgressBar = function ( element ) {
        this.$element = $(element)
      }

  ProgressBar.prototype = {

    change: function ( percentage ) {
      var $element = this.$element

      $element.find('div').width(percentage+"%");
    }

  }


 /* PROGRESS BAR PLUGIN DEFINITION
  * ======================= */

  $.fn.progress = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('progress')
      if (typeof option != "object") $this.data('progress', (data = new ProgressBar(this)))
      if (typeof option == 'number') data.change(option)
    })
  }

  $.fn.progress.ProgressBar = ProgressBar


 /* PROGRESS BAR DATA-API
  * ============== */
  $(function () {
    $('[data-progress]').each(function(){
      var el = $(this);
      el.progress(el.data('progress'))
    });
    console.log("init progress")
  })


}( window.jQuery || window.ender );