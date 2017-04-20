window.onload = function () {

  'use strict';

  var Viewer = window.Viewer;
  var console = window.console || { log: function () {} };
  var pictures = document.querySelector('.docs-pictures');
  var options = {
        // inline: true,
        url: 'data-original',
        tooltip: false,
        zoomable: false,
        movable: false,
        rotatable: false,
        scalable: false,
        title: false,
        inline: false,
      };
  var viewer;

  viewer = new Viewer(pictures, options);


};
