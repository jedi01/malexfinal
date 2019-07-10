<script src="<?php echo base_url("assets/vendor/jquery.calculator/SimpleCalculadorajQuery.js") ?>"></script>
<link rel=stylesheet href="<?php echo base_url("assets/vendor/jquery.calculator/SimpleCalculadorajQuery.css") ?>">
<script type="text/javascript">
function create_calculator(){
    if( $('.calc-modal').size() > 0 ){
        $('.calc-modal').show();
        return;
    }
    var calc_core = $('<div id="calc"></div>');
    var body_overflow = $("body").is(".overflow-hidden");
    var calc_dialog = bootbox.dialog(
        '',
        [],
        {
            header: '<h5>'+globalLang["calculator"]+'</h5>',
            backdrop:false
        }
    );
    calc_dialog.find('.modal-body').append(calc_core);
    calc_dialog.find('.modal-header')
        .addClass("header-calc")
        .removeClass("modal-header")
        .find("h4").remove();
    calc_dialog.removeClass("bootbox")
        .addClass("calc-modal")
        .draggable({
            handle: ".header-calc"
        });
    if( !body_overflow ){
        $('body, html').removeClass("overflow-hidden");
    }
    calc_dialog.on("hide.bs.modal", function(){
        $(this).hide();
      return false;
    });
    calc_core.Calculadora({
        TituloHTML:'', /*Title HTML*/
        Botones:["7","8","9","+","4","5","6","-","1","2","3","*","0",".","=","/"], /* Order Numbers*/
        Signos:["+", "-", "*", "/"], /*Simbols*/
        ClaseBtns1: 'primary', /* Color Numbers*/
        ClaseBtns2: 'success', /* Color Operators*/
        ClaseBtns3: 'warning', /* Color Clear*/
        ClaseColumnas:'col-xs-3 mbottom',
        ClaseBotones:'btn-sm btn-block btn btn-',
        ClasetxtSalida:'form-control txtr',
        ClaseInputBorrar:'btn btn-danger btn-sm btn-block',
        EtiquetaBorrar:'CE' /* Label Ouput Result*/
    });
}
$(document).ready(function(){
    $(document).on("click", ".create_calculator", function(ev){
        create_calculator();
        ev.preventDefault();
    });
});
</script>
