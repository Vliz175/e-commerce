$(document).ready(function () {
  $(".keyword").on("keyup", function () {
    var input = $.trim($(this).val()); // Menggunakan $.trim() pada nilai input
    // alert(input);
    if (input === "") {
      $.get("php/card_content_index.php", function (data) {
        $(".layout").html(data);
      });
    } else {
      $.get("js/cari_produk.php?key=" + input, function (data) {
        $(".layout").html(data);
      });
    }
  });
});
