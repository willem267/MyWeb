$(document).ready(function(){
    // hàm load nội dung của các page vào maincontent
    function loadContent(page) {
        $("#maincontent").load(page);

    }

    $("#contact-link").click(function(e){
        e.preventDefault();
        $(".banner").hide();
        loadContent("templates/lienhe.html");
    });

    $("#register").click(function(e){
        e.preventDefault();
        $(".banner").hide();
        loadContent("templates/dangky.html");
    });

    $(".product-name a").click(function(e){
        e.preventDefault();
        var productname=$(this).text();
        var productImage = $(this).closest('.product').find('.product-img img').attr('src');
        var productPrice = $(this).closest('.product').find('.valueable').text();

        localStorage.setItem('productname', productname);
        localStorage.setItem('productimage', productImage);
        localStorage.setItem('productprice', productPrice);

       
    })


    $(".product-name").click(function(e){
        e.preventDefault();
        loadContent("templates/thongtinsp.html");

    })

});
$(window).on('load',function(){
    $("#loader").fadeOut();
    $(".preloading").delay(300).fadeOut("slow");
    
});
