$(function(){
    var article = new Array();
    var depa = new Array();
    var h1 = document.getElementsByTagName("h1");
    var showbox = document.getElementsByClassName("swiper-wrapper");
    depa[0]="部门名";
    article[0]="部门简介一长串";
    // for(var i =1;i<depa.length;i++){
    // }
    var showSwiper = new Swiper('.swiper-container',{
        initialSlide : 21,
        direction: 'horizontal',
        grabCursor : true,
        autoheight: true
        })
    showbox = showSwiper;
})