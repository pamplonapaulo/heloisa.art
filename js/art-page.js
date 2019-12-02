       (function(){
           
           'use strict';           
           
           var overlay = document.querySelector('#overlay');

           var box = document.querySelector('#galleryItemContent');

           var shareBtn = document.querySelector('.share-btn');

           imgPlacement(box);

           overlay.addEventListener('click', function(){
                quitSelectedImg();
           });

           shareBtn.addEventListener('click', function(){
                shareArt();
           });

           setCommentBtnListener();

           setTimeout(function() {

                var box = document.querySelector('#galleryItemContent');

                enableComments(box);

                facebookCommentsPlacement(box);

           }, 1250);

           function setCommentBtnListener(){

                var commentBtn = document.querySelector('.comment-btn');
                var quitBtn = document.querySelector('.quitComment');

                commentBtn.addEventListener('click', function(){
                    commentsOnAndOff(box, commentBtn);
                });

                quitBtn.addEventListener('click', function(){
                    commentsOnAndOff(box, commentBtn);
                });
           }
                      
           function shareArt(){

            var el = document.querySelector('.comments-wrapper .fb-comments');
            var url = el.getAttribute('data-href');

                FB.ui({
                    method: 'share',
                    href: url,
                }, function(response){

                    console.log(response);

                });
           }
           
           function commentsOnAndOff(box, button){
               
               box.querySelector('.comments-wrapper').classList.toggle('visible');
               button.classList.toggle('active');
               
           }
           
           function enableComments(box){
               
               if (box.querySelector('.placeholder')) {
                                      
                   var dialogBox = box.querySelector('.placeholder');
                   
                   reviewDialogWidth(dialogBox);
                   
                   dialogBox.classList.add('fb-comments');
                   dialogBox.classList.remove('placeholder');
                   
                   FB.XFBML.parse();
               }
           }
           
           function reviewDialogWidth(dialogBox){
               
               var wrappingWidth = document.querySelector('.container').clientWidth;
               
               if (wrappingWidth < 560) {
                   
                   var dialogWidth = (wrappingWidth - 4) + 'px';
                   dialogBox.setAttribute('data-width', dialogWidth);
                   
               }
           }
                      
           function facebookCommentsPlacement(box){
               
               setTimeout(function(){

                   var dialogWrapper = box.querySelector('.comments-wrapper');

                   dialogWrapper.style.marginLeft = ((box.clientWidth - dialogWrapper.clientWidth) / 2) + 'px';
                   
                   appendQuitCommentBtn(box, dialogWrapper);
               }, 4000);
           }
           
           function appendQuitCommentBtn(box, dialogWrapper){
               
               var fragment = document.createDocumentFragment();               
               
               var closeBtn = document.createElement('button');
               closeBtn.classList.add('quitComment');

               var icon = document.createElement('i');
               icon.classList.add('material-icons');
               icon.innerHTML = 'close';

               closeBtn.appendChild(icon);

               closeBtn.addEventListener('click', function(){

                   commentsOnAndOff(box, box.querySelector('.comment-btn'));

               });

               fragment.appendChild(closeBtn);               

               dialogWrapper.insertBefore(fragment, dialogWrapper.childNodes[0]);
           }
           
           function imgPlacement(box){
               
               calculateAspectRatio(box, box.querySelector('img'));
                              
           }
           
           function calculateAspectRatio(box, img){

               var imageIsloaded = false;
               
               img.onload = function() {

                    var frameWidth = document.querySelector('.container').clientWidth;
                    var frameHeight = window.innerHeight;
    
                    var frameAspectRatio = Math.round((frameWidth / frameHeight) * 100) / 100;
                    var imgAspectRatio = Math.round((img.width / img.height) * 100) / 100;
                    
                    ajustImageOnScreen(box, imgAspectRatio, frameAspectRatio);

                    imageIsloaded = true;

                    var loader = document.querySelector('.loader-wrapper');
                    fadeOut(loader,1, 100);

               }            
               setTimeout(function(){

                    if(!imageIsloaded){

                        forceImgLoad();
                        console.log('It seems that the watercolor\'s load took too long. So we forced it.');
                    }
                                      
               }, 1000);
           }
           
           function ajustImageOnScreen(box, imgAspectRatio, frameAspectRatio){
               
                var currentImage = box.querySelector('img').getAttribute('src');
                var img = new Image();
                img.src = '' + currentImage + '';
               
                img.onload = function() {
                                       
                    var img = box.querySelector('img');
                    var container = document.querySelector('.container');
                                        
                    if (imgAspectRatio >= frameAspectRatio)
                        fitImage(img, (container.clientWidth + 'px'), 'auto');
                    
                    if (imgAspectRatio < frameAspectRatio)
                        fitImage(img, 'auto', (window.innerHeight + 'px'));
                    
                    positioningY(box, img);
                    positioningX(container, box, img);

                }
           }
           
           function fitImage(img, width, height){

               img.style.width = width;
               img.style.height = height;
           }
           
           function positioningY(element, img){
               setTimeout(function(){

                   var container = document.querySelector('.container');

                   element.style.marginTop = ((container.clientHeight - img.clientHeight) / 2) + "px";
                                    
               }, 760);
           }
                                 
           function positioningX(container, element, img){
               setTimeout(function(){

                   element.style.width = img.clientwidth;
                   element.style.marginLeft = ((container.clientWidth - img.clientWidth) / 2) + 'px';
                   
                   centerBTNs(element);
                   
               }, 760);
           }

           function forceImgLoad(){

                var newSrc;

                var img = document.querySelector('figure img');

                var currentSrc = img.getAttribute('src');

                if(currentSrc.startsWith('assets')){
                    newSrc = './' + currentSrc;
                } else if(currentSrc.startsWith('./assets')){
                    newSrc = currentSrc.substr(2);
                }

                img.setAttribute('src', newSrc);

           }
                               
           function centerBTNs(element){
               setTimeout(function(){
                   
                   var container = document.querySelector('.container');
                   var btnWrapper = element.querySelector('.btns-wrapper');

                   btnWrapper.style.width = container.clientWidth + 'px';
                   btnWrapper.style.marginLeft = '-' + ((container.clientWidth - element.clientWidth) / 2) + 'px';
                   
                   var btnWidth = 66;
                   
                   element.querySelector('.close').style.marginLeft = (container.clientWidth - btnWidth) + 'px';
                   
                   btnWrapper.classList.add('visible');
                   
                   var box = document.querySelector('article');

                   fadeIn(box,0.25, 100);

                    setTimeout(function(){

                        var socialBtns = document.querySelectorAll('.fb-btn');

                        socialBtns[0].classList.add('visible');
                        socialBtns[1].classList.add('visible');                        

                    }, 3500);
                   
               }, 760);
           }
                      
           function quitSelectedImg(){
                                             
               var selected = document.querySelector('#galleryItemContent');
               
               fadeOut(selected,2, 100);
               
               setTimeout(function() {

                   window.location.href = "./index.php";
                   
               }, 1000);
           }

           function fadeIn(element,time, maxOpacity){
               processa(element,time,0,maxOpacity);
           } 

           function fadeOut(element,time, maxOpacity){
               processa(element,time,maxOpacity,0);
           }

           function processa(element,time,initial,end){

               if(initial == 0){
                   var increment = 2;
                   element.style.display = "block";
               } else {
                   var increment = -2;
               }
               var opc = initial;    

               var intervalo = setInterval(function(){
                   if((opc == end)){
                       if(end == 0){
                           element.style.display = "none";
                       }
                       clearInterval(intervalo);
                   } else {
                       opc += increment;
                       element.style.opacity = opc/100;
                       element.style.filter = "alpha(opacity="+opc+")";
                   }
               },time * 10);    
            } 

       })();
