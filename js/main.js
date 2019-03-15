$(function(){
    var showSwiper = new Swiper('.swiper-container',{
        // initialSlide : 21,
        direction: 'horizontal',
        grabCursor : true,
        // autoheight: true,
        loop: true,
        eventTarget : 'container',
        releaseFormElements : false,
        watchActiveIndex : true,
        visibilityFullFit : true,
        keyboardControl : true,
        mousewheelControl : true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
        });
    var article = new Array();
    var depa = new Array(20);
    var showbox = document.getElementsByClassName("swiper-wrapper");
    depa[0] = "技术部-代码组";
    depa[1] = "技术部-设计组";
    depa[2] = "技术部（北校专业）";
    depa[3] = "策划推广部";
    depa[4] = "编辑部-原创写手";
    depa[5] = "编辑部-摄影";
    depa[6] = "编辑部-可视化设计";
    depa[7] = "视觉设计部";
    depa[8] = "视频部-策划导演";
    depa[9] = "视频部-摄影摄像";
    depa[10] = "视频部-剪辑特效";
    depa[11] = "外联部";
    depa[12] = "节目部-国语组";
    depa[13] = "节目部-英语组";
    depa[14] = "节目部-粤语组";
    depa[15] = "人力资源部";
    depa[16] = "综合管理部-行政管理";
    depa[17] = "综合管理部-物资财物";
    depa[18] = "综合管理部-撰文记者";
    depa[19] = "综合管理部-摄影记者";
    depa[20] = "产品运营部（北校专业）";
    article[0]="部门简介一长串";
    var num = showSwiper.realIndex;
    $("#depa").html(""+String(depa[num])+"");
}) 