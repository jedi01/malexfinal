
<!-- Page Header -->
<ol class="breadcrumb">
    <div class="flip pull-left">
        <h1 class="h2 page-title"><?php echo $page_title;?></h1>
        <div class="text-muted page-desc"><?php echo $page_subheading ?></div>
    </div>
    <div class="flip pull-right">
        <button type="button" id="reportrange" class="btn btn-secondary dropdown-toggle">
            <i class="fa fa-calendar m-x-h"></i> <small></small>
        </button>
        <div class="btn-group tip select_currency">
            <a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><small></small> <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php foreach ($currencies as $currency => $label): ?>
                    <li class="dropdown-item" data-currency="<?php echo $currency ?>"><?php echo $label ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</ol>

<div class="container-fluid">
    <div class="p-x-h">
        <div class="row row-equal card-same-height">
            <div class="col-lg-5 col-lg-offset-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title m-a-0"><?php echo lang("spending"); ?></h4>
                    </div>
                    <div class="card-block">
                        <div class="chart_total spending_total">
                            <span></span>
                            <small class="text-muted"><?php echo lang("total_spending"); ?></small>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="overview_chart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title m-a-0"><?php echo lang("outstanding_revenue"); ?></h4>
                    </div>
                    <div class="card-block">
                        <div class="chart_total outstanding_total">
                            <span></span>
                            <small class="text-muted"><?php echo lang("total_outstanding"); ?></small>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="outstanding_revenue_chart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-equal">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="card">
                    <div class="card-header card-header-inverse card-header-info">
                        <h4 class="card-title m-a-0"><?php echo lang("total_profit"); ?></h4>
                    </div>
                    <div class="card-block">
                        <div class="chart_total profit_total">
                            <span></span>
                            <small class="text-muted"><?php echo lang("total_profit"); ?></small>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="total_profit" height="270"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
$(function(){

    var pieChart = undefined;
    function drawExpensesPie(pieData, labels){
        if( pieChart != undefined ){
            pieChart.destroy();
        }
        pieChart = new Chart(document.getElementById('overview_chart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: palette('all', pieData.length).map(function(hex) {
                        return '#' + hex;
                    }),
                    data: pieData
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                cutoutPercentage: 80,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data.labels[tooltipItem.index]+': '+Format_Currency(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index], true, currency_row);
                        },
                    }
                },
                legend: {
                    display: true,
                    position: "left",
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        fontSize: 11,
                    }
                }
            }
        });
    }

    var barChart = undefined;
    function drawOutstandingRevenueBars(barData, max){
        if( barChart != undefined ){
            barChart.destroy();
        }
        barChart = new Chart(document.getElementById('outstanding_revenue_chart'), {
            type: 'horizontalBar',
            data: {
                datasets: [{
                    label: globalLang["overdue"],
                    backgroundColor: ['#FF6384'],
                    hoverBackgroundColor: ['#C33E5A'],
                    data: [barData["overdue"]]
                },{
                    label: globalLang["unpaid"],
                    backgroundColor: ['#FFCE56'],
                    hoverBackgroundColor: ['#B08110'],
                    data: [barData["unpaid"]]
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data.datasets[tooltipItem.datasetIndex].label+': '+Format_Currency(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index], true, currency_row);
                        },
                    }
                },
                legend: {
                    display: true,
                    position: "bottom",
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        fontSize: 11,
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            min: 0,
                            //max: getnextdec(max),
                        }
                    }],
                },
            }
        });
    }

    // Report Range
    var chart = undefined;
    function drawReportRangeChart(data, js_format, max, min){
        if( chart != undefined ){
            chart.destroy();
        }
        chart = new Chart(document.getElementById('total_profit'), {
            type: 'line',
            data: data,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                elements: {
                    line: {
                        tension: '0.000001',
                    },
                    point: {
                        pointStyle: 'circle',
                        radius: 5,
                        borderWidth: 2
                    }
                },
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        beforeLabel: function(tooltipItem, data) {
                            return globalLang['income']+': '+Format_Currency(data.datasets_details[tooltipItem.index].income, true, currency_row);
                        },
                        label: function(tooltipItem, data) {
                            return "";
                        },
                        afterLabel: function(tooltipItem, data) {
                            return globalLang['expenses']+': '+Format_Currency(data.datasets_details[tooltipItem.index].expenses, true, currency_row);
                        },
                        footer: function(tooltipItem, data) {
                            return globalLang['profit']+': '+Format_Currency(data.datasets[0].data[tooltipItem[0].index], true, currency_row);
                        }
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
                            //max: getnextdec(max),
                            //min: getnextdec(min, true),
                        }
                    }],
                },
            }
        });
    }

    function getnextdec(value, negative){
        val = "1";
        value = Math.abs(value);
        for (var i = (value+"").length - 1; i > 0; i--) {
            val += "0";
        }
        if( negative && parseInt(val)*2.5 < value ){
            val += "0";
        }
        if( !negative && parseInt(val)*2.5 < value ){
            val += "0";
        }
        val = parseInt(val) * 2.5;
        if( negative == true ){
            val = -val;
        }
        return val;
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
        ajax_data['currency']= $('.select_currency').data("value");
        $.ajax({
            type: "POST",
            url: SITE_URL+"/reports/getTotalProfit",
            data: ajax_data,
            dataType: "JSON",
            success: function(result) {
                var lineChartData = {
                    labels : result.dates.dates_view,
                    datasets_details : result.values_details,
                    datasets : result.values
                }
                $('.profit_total span').text(Format_Currency(result.total, true, currency_row));
                drawReportRangeChart(lineChartData, result.dates.js_format, parseInt(result.max), parseInt(result.min));
            },
            beforeSend: function(){$('.loading-backdrop').fadeIn();},
            complete: function(){$('.loading-backdrop').fadeOut();}
        });
        $.ajax({
            type: "POST",
            url: SITE_URL+"/reports/getExpensesPie",
            data: ajax_data,
            dataType: "JSON",
            success: function(result) {
                $('.spending_total span').text(Format_Currency(result.total, true, currency_row));
                drawExpensesPie(result.data, result.labels);
            },
            beforeSend: function(){$('.loading-backdrop').fadeIn();},
            complete: function(){$('.loading-backdrop').fadeOut();}
        });
        $.ajax({
            type: "POST",
            url: SITE_URL+"/reports/getOutstandingRevenueBars",
            data: ajax_data,
            dataType: "JSON",
            success: function(result) {
                $('.outstanding_total span').text(Format_Currency(result.total, true, currency_row));
                drawOutstandingRevenueBars(result.data, parseInt(result.max));
            },
            beforeSend: function(){$('.loading-backdrop').fadeIn();},
            complete: function(){$('.loading-backdrop').fadeOut();}
        });
    }
    $('#reportrange').daterangepicker(daterangepicker_init, cb).data('daterangepicker');

    $('.select_currency .dropdown-menu li').on('click', function(){
        $('.select_currency').setCurrency($(this).data("currency"));
        return false;
    });
    var currency_row = {};
    $.fn.setCurrency = function(currency){
        $(this).find('.dropdown-menu li').removeClass("active");
        var item = $(this).find('.dropdown-menu li[data-currency="'+currency+'"]');
        var text = $(item).text();
        $(item).addClass('active');
        currency_row.currency = currency;
        $(this).find('.dropdown-toggle small').text(text);
        $(this).data("value", currency);
        $(this).trigger("change");
        return this;
    }
    $('.select_currency')
        .on("change", function(){
            $('#reportrange').data('daterangepicker').callback();
        })
        .setCurrency('<?php echo CURRENCY_PREFIX ?>');
});
</script>
<script src="<?php echo base_url("assets/js/libs/colour_palette.js") ?>"></script>
