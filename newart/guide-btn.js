(function(){

    'use strict';

    var btn = document.querySelector('form .directions');
    var wrapper = document.querySelector('form .advice');

    btn.addEventListener('click', function(){

        wrapper.classList.toggle('inactive');
        btn.classList.toggle('inactive');

    }, false);

})();