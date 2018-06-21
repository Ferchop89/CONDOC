$(function() {
  $("#nacionalidad").change(function() {
    if ($("#mex").is(":selected")) {
      $("#paises_mexicano").show();
      $("#paises_otro").hide();
    } else {
      $("#paises_mexicano").hide();
      $("#paises_otro").show();
    }
  }).trigger('change');
});