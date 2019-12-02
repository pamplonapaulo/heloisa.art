(function(){

    //'use strict';

    var el = document.querySelector('body');

    function swipedetect(el, callback){

        var touchsurface = el,
        swipedir,
        startX,
        startY,
        distX,
        distY,
        threshold = 50, //required min distance traveled to be considered swipe
        restraint = 100, // maximum distance allowed at the same time in perpendicular direction
        allowedTime = 300, // maximum time allowed to travel that distance
        elapsedTime,
        startTime,
        handleswipe = callback || function(swipedir){}

        touchsurface.addEventListener('touchstart', function(e){
            var touchobj = e.changedTouches[0]
            swipedir = 'none'
            dist = 0
            startX = touchobj.pageX
            startY = touchobj.pageY
            startTime = new Date().getTime() // record time when finger first makes contact with surface
            //e.preventDefault()
        }, false)

        touchsurface.addEventListener('touchmove', function(e){
            e.preventDefault() // prevent scrolling when inside DIV
        }, false)

        touchsurface.addEventListener('touchend', function(e){
            var touchobj = e.changedTouches[0]
            distX = touchobj.pageX - startX // get horizontal dist traveled by finger while in contact with surface
            distY = touchobj.pageY - startY // get vertical dist traveled by finger while in contact with surface
            elapsedTime = new Date().getTime() - startTime // get time elapsed
            if (elapsedTime <= allowedTime){ // first condition for swipe met
                if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){ // 2nd condition for horizontal swipe met
                    swipedir = (distX < 0)? 'left' : 'right' // if dist traveled is negative, it indicates left swipe
                }
                else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint){ // 2nd condition for vertical swipe met
                    swipedir = (distY < 0)? 'up' : 'down' // if dist traveled is negative, it indicates up swipe
                }
            }
            handleswipe(swipedir)
            //e.preventDefault()
        }, false)
    }

    swipedetect(el, function(swipedir){

        if(document.body.clientWidth < 1024){

            var navBtnsPrev = document.querySelector('.btn-swiper.btn-prev');
            var navBtnsNext = document.querySelector('.btn-swiper.btn-next');
    
            var navBtnsPrevIsOn = navBtnsPrev.classList.contains('visible');
            var navBtnsNextIsOn = navBtnsNext.classList.contains('visible');
    
            var pagePrev = navBtnsPrev.getAttribute('href');
            var pageNext = navBtnsNext.getAttribute('href');

            if (swipedir =='right' && navBtnsPrevIsOn)
                window.location.href = pagePrev;
            if (swipedir =='left' && navBtnsNextIsOn)
                window.location.href = pageNext;
        }
    })

})();