var escuelas = <?php echo json_encode($escuelas); ?>;
escuelas.forEach($(function() {
  $("#seleccion_periodo").change(function() {
    if ($("#periodo").is(":selected")) {
      $("#periodo_show").show();
      $("#mes_anio_show").hide();
    } else {
      $("#periodo_show").hide();
      $("#mes_anio_show").show();
    }
  }).trigger('change');
}));