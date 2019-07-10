<!-- Page Header -->
<ol class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
    </div>
    <div class="flip pull-right">
        <button type="button" id="reportrange" class="btn btn-secondary dropdown-toggle">
            <i class="fa fa-calendar m-x-h"></i> <small></small>
        </button>
        <div class="btn-group tip" id="select_currency">
            <a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><small></small> <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right select_currency">
                <?php foreach ($currencies as $currency => $label): ?>
                    <li class="dropdown-item" data-currency="<?php echo $currency ?>"><?php echo $label ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</ol>

<div class="container-fluid">
<div class="p-x-h">
<!-- WIDGETS -->
<div class="row row-equal">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="row row-equal">
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card" id="this_year">
                    <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                        <?php echo lang("daterange_this_year") ?>
                    </div>
                    <div class="card-block text-xs-center">
                        <h3 class="home-card-number"></h3>
                    </div>
                    <div class="card-block p-y-0 p-x-2 b-t-1 small">
                        <div class="row">
                            <div class="col-xs-6 b-r-1 p-y-1">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-6 p-y-1 text-xs-right">
                                <div class="font-weight-bold"></div>
                                <div class="text-muted"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card" id="this_month">
                    <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                        <?php echo lang("daterange_this_month") ?>
                    </div>
                    <div class="card-block text-xs-center">
                        <h3 class="home-card-number"></h3>
                    </div>
                    <div class="card-block p-y-0 p-x-2 b-t-1 small">
                        <div class="row">
                            <div class="col-xs-6 b-r-1 p-y-1">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-6 p-y-1 text-xs-right">
                                <div class="font-weight-bold"></div>
                                <div class="text-muted"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card" id="today">
                    <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                        <?php echo lang("daterange_today") ?>
                    </div>
                    <div class="card-block text-xs-center">
                        <h3 class="home-card-number"></h3>
                    </div>
                    <div class="card-block p-y-0 p-x-2 b-t-1 small">
                        <div class="row">
                            <div class="col-xs-6 b-r-1 p-y-1">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-6 p-y-1 text-xs-right">
                                <div class="font-weight-bold"></div>
                                <div class="text-muted"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card" id="paid">
                    <div class="card-header card-header-inverse card-header-success small font-weight-bold text-xs-center">
                        <?php echo lang("paid_invoices") ?>
                    </div>
                    <div class="card-block text-xs-center">
                        <h3 class="home-card-number"></h3>
                    </div>
                    <div class="card-block p-y-0 p-x-2 b-t-1 small">
                        <div class="row">
                            <div class="col-xs-12 p-y-1 text-xs-center"><a href="#"></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card" id="unpaid">
                    <div class="card-header card-header-inverse card-header-warning small font-weight-bold text-xs-center">
                        <?php echo lang("unpaid_invoices") ?>
                    </div>
                    <div class="card-block text-xs-center">
                        <h3 class="home-card-number"></h3>
                    </div>
                    <div class="card-block p-y-0 p-x-2 b-t-1 small">
                        <div class="row">
                            <div class="col-xs-12 p-y-1 text-xs-center"><a href="#"></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card" id="overdue">
                    <div class="card-header card-header-inverse card-header-danger small font-weight-bold text-xs-center">
                        <?php echo lang("overdue_invoices") ?>
                    </div>
                    <div class="card-block text-xs-center">
                        <h3 class="home-card-number"></h3>
                    </div>
                    <div class="card-block p-y-0 p-x-2 b-t-1 small">
                        <div class="row">
                            <div class="col-xs-12 p-y-1 text-xs-center"><a href="#"></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- INVOICES PER DATE -->
<div class="row row-equal">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="card">
            <div class="card-header card-header-inverse card-header-info">
                <h4 class="card-title"><?php echo lang("invoices_per_date"); ?></h4>
                <div class="small" style="margin-top:-10px;"><?php echo lang("invoices_per_date_subheading"); ?></div>
            </div>
            <div class="card-block">
                <div class="chart-wrapper">
                    <canvas id="invoices_per_date" height="270"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LAST INVOICE & OVERVIEW CHART -->
<div class="row row-equal card-same-height">
    <div class="col-lg-5 col-lg-offset-1">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo lang("last_invoices"); ?></h4>
                <div class="small text-muted" style="margin-top:-10px;"><?php echo lang("last_invoices_subheading"); ?></div>
            </div>
            <div class="card-block p-y-0 p-x-q">
                <table class="table table-sm table-hover table-align-middle m-b-0" id="last_invoices" style="display: table;">
                    <thead class="transparent">
                        <tr>
                            <th style="width: 120px;"><?php echo lang("date") ?></th>
                            <th><?php echo lang("reference") ?></th>
                            <th style="width: 50px;" class="text-xs-center"><i class="fa fa-external-link"></i></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo lang("overview_chart"); ?></h4>
                <div class="small text-muted" style="margin-top:-10px;"><?php echo lang("overview_chart_subheading"); ?></div>
            </div>
            <div class="card-block">
                <div class="chart-wrapper">
                    <canvas id="overview_chart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script src="<?php echo base_url("assets/vendor/jquery-numberAnimate/jquery.animateNumbers.js") ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function(){

    function dashboardData(result, currency){
        lastInvoices(result.invoices);
        drawPieChart(result.overview_chart.labels, result.overview_chart.data);
        //this_year
        $('#this_year .card-block h3').html('<span class="animate-number" data-value="'+Format_float(result.this_year.total)+'" data-animation-duration="700">0</span> <small>'+getFormatedCurrency(currency)+'</small>');
        $('#this_year .card-block.small a').html(globalLang['number_of_invoices'].replace("%s", result.this_year.number));
        $('#this_year .card-block.small a').attr("href", '<?php echo site_url("/invoices?f=date&fv=".date("Y-01-01")."~".date("Y-12-31")); ?>&currency='+currency);
        $('#this_year .card-block.small .text-xs-right .font-weight-bold').html(Format_float(result.this_year.percent, 2)+' %');
        $('#this_year .card-block.small .text-xs-right .text-muted').html('<small><i class="fa fa-arrow-'+result.this_year.arrow+'"></i></small>');

        //this_month
        $('#this_month .card-block h3').html('<span class="animate-number" data-value="'+Format_float(result.this_month.total)+'" data-animation-duration="700">0</span> <small>'+getFormatedCurrency(currency)+'</small>');
        $('#this_month .card-block.small a').html(globalLang['number_of_invoices'].replace("%s", result.this_month.number));
        $('#this_month .card-block.small a').attr("href", '<?php echo site_url("/invoices?f=date&fv=".date("Y-m-01")."~".date('Y-m-d', strtotime(date("Y-m-01")." +1 month -1 day"))); ?>&currency='+currency);
        $('#this_month .card-block.small .text-xs-right .font-weight-bold').html(Format_float(result.this_month.percent, 2)+' %');
        $('#this_month .card-block.small .text-xs-right .text-muted').html('<small><i class="fa fa-arrow-'+result.this_month.arrow+'"></i></small>');

        //today
        $('#today .card-block h3').html('<span class="animate-number" data-value="'+Format_float(result.today.total)+'" data-animation-duration="700">0</span> <small>'+getFormatedCurrency(currency)+'</small>');
        $('#today .card-block.small a').html(globalLang['number_of_invoices'].replace("%s", result.today.number));
        $('#today .card-block.small a').attr("href", '<?php echo site_url("/invoices?f=date&fv=".date("Y-m-d")."~".date("Y-m-d")); ?>&currency='+currency);
        $('#today .card-block.small .text-xs-right .font-weight-bold').html(Format_float(result.today.percent, 2)+' %');
        $('#today .card-block.small .text-xs-right .text-muted').html('<small><i class="fa fa-arrow-'+result.today.arrow+'"></i></small>');

        //paid
        $('#paid .card-block h3').html('<span class="animate-number" data-value="'+Format_float(result.paid.total)+'" data-animation-duration="700">0</span> <small>'+getFormatedCurrency(currency)+'</small>');
        $('#paid .card-block.small a').html(globalLang['number_of_invoices'].replace("%s", result.paid.number));
        $('#paid .card-block.small a').attr("href", '<?php echo site_url("/invoices?f=status&fv=paid"); ?>&currency='+currency);

        //unpaid
        $('#unpaid .card-block h3').html('<span class="animate-number" data-value="'+Format_float(result.unpaid.total)+'" data-animation-duration="700">0</span> <small>'+getFormatedCurrency(currency)+'</small>');
        $('#unpaid .card-block.small a').html(globalLang['number_of_invoices'].replace("%s", result.unpaid.number));
        $('#unpaid .card-block.small a').attr("href", '<?php echo site_url("/invoices?f=status&fv=unpaid"); ?>&currency='+currency);

        //overdue
        $('#overdue .card-block h3').html('<span class="animate-number" data-value="'+Format_float(result.overdue.total)+'" data-animation-duration="700">0</span> <small>'+getFormatedCurrency(currency)+'</small>');
        $('#overdue .card-block.small a').html(globalLang['number_of_invoices'].replace("%s", result.overdue.number));
        $('#overdue .card-block.small a').attr("href", '<?php echo site_url("/invoices?f=status&fv=overdue"); ?>&currency='+currency);

        $('.animate-number').each(function(){
            if( $(this).data("value") != "" ){
                $(this).animateNumbers($(this).attr("data-value"), true, parseInt($(this).attr("data-animation-duration")));
            }
        });
    }

    var pieChart;
    function drawPieChart(chart_labels, chart_data){
        if( pieChart != undefined ){
            pieChart.destroy();
        }
        var pieData = {
            labels: chart_labels,
            datasets: [{
                data: chart_data,
                backgroundColor: ['#FFCE56','#4dbd74','#36A2EB','#FF6384','#1f1f1f','#a9a9a9','#af4fb5'],
                hoverBackgroundColor: ['#B08110','#41af67','#2176B0','#C33E5A','#0c0c0c','#a2a2a2','#4d9ca0'],
            }]
        };
        var ctx = document.getElementById('overview_chart');
        pieChart = new Chart(ctx, {
            type: 'pie',
            data: pieData,
            options: {
                maintainAspectRatio: false,
                responsive: true
            }
        });
    }

    function lastInvoices(invoices){
        $('#last_invoices tbody tr').remove();
        for (var i = 0; i < invoices.length; i++) {
            invoice = invoices[i];
            var tr = '<tr>'+
                '<td>'+Format_Date(invoice.date)+'</td>'+
                '<td>'+
                    '<a href="'+SITE_URL+'/invoices/open/'+invoice.id+'">'+invoice.reference+'</a>'+
                '</td>'+
                '<td>'+
                    '<a href="'+SITE_URL+'/invoices/edit?id='+invoice.id+'" class="tip" title="'+globalLang['edit']+'"><i class="fa fa-pencil"></i></a>'+
                    '<a href="#" onclick="MyWindow=window.open(\''+SITE_URL+'/invoices/view?id='+invoice.id+'\', WINDDOW_NAME,WINDDOW_CONFIGURATION); return false;" class="tip" title="'+globalLang['print']+'"><i class="fa fa-print"></i></a>'+
                '</td>'+
            '</tr>';
            $('#last_invoices tbody').append($(tr));
        }
    }

    card_max_height = 0;
    $('.card-same-height .card').each(function(){
        card_max_height = Math.max(card_max_height, $(this).height());
    });
    $('.card-same-height .card').css("minHeight", card_max_height);

    // Report Range
    var chart = undefined;
    function drawReportRangeChart(data, js_format){
        var ctx = document.getElementById('invoices_per_date');
        if( chart != undefined ){
            chart.destroy();
        }
        chart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        fontSize: 11,
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data.datasets[tooltipItem.datasetIndex].label+": "+Format_Currency(tooltipItem.yLabel, true);
                        },
                    },
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            callback: function(value, index, values) {
                                return moment(value, js_format, "en").locale(globalLang["lang"]).format(js_format);
                            }
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            callback: function(value, index, values) {
                                return Format_Currency(value, true);
                            }
                        }
                    }]
                },
            }
        });
    }

    function cb(start, end) {
        if( start == undefined && end == undefined ){
            start = this.startDate;
            end = this.endDate;
        }
        $('#reportrange small').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var ajax_data        = {};
        ajax_data[CSRF_NAME] = CSRF_HASH;
        ajax_data["start"]   = start.locale("en").format("YYYY-MM-DD");
        ajax_data["end"]     = end.locale("en").format("YYYY-MM-DD");
        ajax_data['currency']= $('#select_currency').data("value");
        $.ajax({
            type: "POST",
            url: SITE_URL+"/home/getReportRangeChart",
            data: ajax_data,
            dataType: "JSON",
            success: function(result) {
                var lineChartData = {
                    labels : result.dates.dates_view,
                    datasets : result.values
                }
                drawReportRangeChart(lineChartData, result.dates.js_format);
            },
            beforeSend: function(){$('.loading-backdrop').fadeIn();},
            complete: function(){$('.loading-backdrop').fadeOut();}
        });
        $.ajax({
            type: "POST",
            url: SITE_URL+"/home/getDashboardData",
            data: ajax_data,
            dataType: "JSON",
            success: function(result) {
                dashboardData(result, ajax_data['currency']);
            },
            beforeSend: function(){$('.loading-backdrop').fadeIn();},
            complete: function(){$('.loading-backdrop').fadeOut();}
        });
    }
    $('#reportrange').daterangepicker(daterangepicker_init, cb).data('daterangepicker');

    $(document).on("click", ".select_currency li", function(){
        $('#select_currency').setCurrency($(this).data("currency"));
        return false;
    });

    var currency_row = {};
    var currencies = <?php echo json_encode($currencies) ?>;
    $.fn.setCurrency = function(currency){
        $('.select_currency li').removeClass("active");
        var item = $('.select_currency li[data-currency="'+currency+'"]');
        $(item).addClass('active');
        currency_row.currency = currency;
        $('#select_currency .dropdown-toggle small').text(currencies[currency]);
        $('#select_currency').data("value", currency);
        $('#select_currency').trigger("change");
        return $('#select_currency');
    }
    $('#select_currency')
        .on("change", function(){
            $('#reportrange').data('daterangepicker').callback();
        })
        .setCurrency('<?php echo CURRENCY_PREFIX ?>');
});
</script>
