
// サイドメニューボタン押下イベント
$(function(){
    $('.menuBoxBtn').on('click',function(){
        $('.menuBox').addClass('slideIn');
        $('.menuBox').removeClass('slideOut');
        return false;
    });
    $(document).on('click',function(e){
        if(!$(e.target).closest('.menuBox').length) {
            // ターゲット要素の外側をクリックした時の操作
            $('.menuBox').removeClass('slideIn');
            $('.menuBox').addClass('slideOut');
        }
    });
  $(window).scroll(function(){
    var scrollAmount = $(this).scrollTop();
    if(scrollAmount <= 0)
    {
      $('.jumpTopBtn').fadeOut();
    }
    else
    {
      $('.jumpTopBtn').fadeIn();
    }
  });
  $('a[href^="#"]').on('click',function(){
    var speed = 1000;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    $("html, body").animate({scrollTop:position}, speed, "swing");
    return false;
  });
  // 投稿コメントの文字数カウント
  $('#intro').keyup(function(){
    var count = $(this).val().length;
    if(count < 0)
    {
      count = 0;
    }
    $('#strCounter').text("文字カウント : "+ count);
  });
  // いいね一覧のfadeInとfadeOut
  $('#favStr').hover(
    function(){
      $('#favDetail').fadeIn();
    },
    function(){
      $('#favDetail').fadeOut();
    }

  );


  // id="ufile"の変化でコールバック
  $("#fileInput").change(function()
  {
      // 選択ファイルの有無をチェック
      if (!this.files.length) {
          alert('ファイルが選択されていません');
          return;
      }
      
      // Formからファイルを取得
      var file = this.files[0];
      // (1) HTMLのCanvas要素の取得
      var canvas = $("#canvas");

      // (2) getContext()メソッドで描画機能を有効にする
      var ctx = canvas[0].getContext('2d');

      // 描画イメージインスタンス化
      var image = new Image();

      // File API FileReader Objectでローカルファイルにアクセス
      var fr = new FileReader();

      // ファイル読み込み読み込み完了後に実行 [非同期処理]
      fr.onload = function(evt) {

          // 画像がロードされた後にcanvasに描画を行う [非同期処理]
          image.onload = function() {
              // (3) プレビュー(Cnavas)のサイズを指定
              var cnvsH = 240;
              var cnvsW = image.naturalWidth*cnvsH/image.naturalHeight;
              // (4) Cnavasにサイズアトリビュートを設定する
              canvas.attr('width', cnvsW);
              canvas.attr('height', cnvsH);
              // (5) 描画
              ctx.drawImage(image, 0, 0, cnvsW, cnvsH);
          }
          // 読み込んだ画像をimageのソースに設定
          image.src = evt.target.result;
      }
      // fileを読み込む データはBase64エンコードされる
      fr.readAsDataURL(file);
  });
})


