       (function(){
           
           'use strict';
                      
           // Hamburguer Menu
           var menuBtn = document.querySelector('.menu-btn');
           var spansArray = menuBtn.querySelectorAll('span');
           var menu = document.querySelector('nav');

           menuBtn.addEventListener('click', function(){
                
                for (var i=0; i<spansArray.length; i++){
                    
                    spansArray[i].classList.toggle('animate');
                    menu.classList.toggle('visible');
                }
           });
           
           // Language Switcher
           var switcher = document.getElementById('idiom-switcher');
           
           switcher.addEventListener('click', function(){
               
               toggleIdiomsIcon('.langEN');
               toggleIdiomsIcon('.langPT');
               
               document.querySelector('.on').click();
               document.querySelector('.headline-wrapper').childNodes[3].classList.toggle('enlarged');
               
           });
           
           function toggleIdiomsIcon(lang){
               
               document.querySelector(lang).classList.toggle('on');
               
           }
           
           function setSwitcherStatus(){
               
               var subtitle = document.querySelector('.headline-wrapper').childNodes[3];
               
               if (subtitle.innerText === 'WATERCOLOR & STUFF'){
                   switcher.checked = false;
                   toggleIdiomsIcon('.langEN');
               } else {
                   subtitle.classList.add('enlarged');
                   switcher.checked = true;
                   toggleIdiomsIcon('.langPT');
               }
                   
           }
           setSwitcherStatus();
           
           
           // Get current page:           
           var page = window.location.pathname.split("/").pop();

           if (page == "index.php" || page == ""){
               
                setThumbListeners();

                window.addEventListener('load', function(){

                    var overlay = document.querySelector('#overlay');
                    fadeOut(overlay,1, 100);

                    var loader = document.querySelector('.loader-wrapper');
                    fadeOut(loader,1, 100);

                }, false);
           } 

           // LightBox
           function setThumbListeners(){

                var thumbAnchors= document.querySelectorAll('.gallery .item');
                                         
                for (var i=0; i<thumbAnchors.length; i++){
                    
                    thumbAnchors[i].addEventListener('click', function(){

                        var overlay= document.querySelector('#overlay');                

                        fadeIn(overlay,0.25, 100);

                        var url = this.getAttribute('data-link');

                        setTimeout(function() {

                            window.location.href = url;  

                        }, 1000);
        
                      });
                }
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
