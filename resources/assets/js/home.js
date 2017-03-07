$(document).ready(function(){
  // update avatar
  var fileInput=document.querySelector('input[type=file]'),
  previewImg=document.querySelector('img[title=preview-img]');
  fileInput.addEventListener('change',function(){
    var file=this.files[0];
    var reader=new FileReader();
    reader.addEventListener("load",function(){
      previewImg.src=reader.result;
    },false);
    reader.readAsDataURL(file);
  },false);

  // person information
   var getClickIndex=document.getElementsByClassName("addEdit");
   var count=0;
   var clickIndex=[];
   $(".addEdit").click(function(){
     count+=1;
     var getCurrentIndex=$(".addEdit").index(this);//get current click item index
     clickIndex[count]=getCurrentIndex;//record current click item index
       $(".addInfor").eq(clickIndex[count-1]).fadeOut("fast");
       $(".displayInfor").eq(clickIndex[count-1]).fadeIn("fast");
       //cancel Previous click style
       $(".displayInfor").eq(clickIndex[count]).fadeOut("fast");
       $(".addInfor").eq(clickIndex[count]).fadeIn("fast");
       //add click item for style
   });

  //  person introduce
  $(".addIntro").click(function(){
    $(".introDetaile").eq(0).addClass("introDetailHide");
    $(".introDetaile").eq(1).removeClass("introDetailHide");
    $(".cancelBtn").click(function(){
      $(".introDetaile").eq(0).removeClass("introDetailHide");
      $(".introDetaile").eq(1).addClass("introDetailHide");
    });
  });

  $(".saveBtn").click(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      var data = {
          introduce: $('#userIntro').val()
      };
      console.log(data);
      $.ajax({
          type: "POST",
          url: '/home',
          data: data,
          dataType: 'json',
          success: function (data) {
              console.log(data);
              var intro = '<p id="showIntro" >'+(data.introduce)+'</p>';
              $(".introDetaile").eq(0).removeClass("introDetailHide");
              $(".introDetaile").eq(1).addClass("introDetailHide");
              $('.introDetaile').html(intro);
              console.log(intro);
          },
          error: function (data, json, errorThrown) {
              console.log(data);
              $('#debug').html(data.responseText);
              var errors = data.responseJSON;
              var errorsHtml = '';
              $.each(errors, function (key, value) {
                  errorsHtml += '<li>' + value[0] + '</li>';
              });
          }
      });
  });
});
