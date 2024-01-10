$(document).ready(function () {

    LoadElement('#statistics');

    setTimeout(function () {

        StatisticsData();
    }, 2000);

    function StatisticsData() {


        var _csrf = $("#_csrf").val();
        var sId = $('#statictic_subject_id').val();

        if (sId !== '') {
            $.ajax({
                url: HOST_NAME + "group_admin/statistics/",
                type: "POST",
                data: { 
                    s_id: sId, 
                    _csrf: _csrf ,
                    check:"group_admin_statistics_op_code"
                },
                dataType: "json",
                traditional: true,
                success: function (result) {

                    UnLoadElement('#statistics');
                    console.log(result);

                    $('#last_month_visit').html(result.last_month_visit_count);    
                    $('#last_month_visit_changes').html(result.last_month_visit_changes); 
                    $('#last_month_visit_changes').addClass(result.last_month_visit_changes_type); 
                    $('#last_6month_visit').html(result.last_6_month_visit_count);  
                    
                    $('#last_month_posts').html(result.last_month_post_count);    
                    $('#last_month_posts_changes').html(result.last_month_post_changes); 
                    $('#last_month_posts_changes').addClass(result.last_month_post_changes_type); 
                    $('#last_6month_posts').html(result.last_6_month_post_count);  


                    var browserData = result.browserData;


                    var deviceData = result.deviceData;

                    var categoriesWeeklyVisitData = result.categoriesWeeklyVisitData;
                    var categoriesMonthlyVisitData = result.categoriesMonthlyVisitData;

                    var dailyVisitData =result.dailyVisitData;
                    var dailyVisitCategories =result.dailyVisitCategories;
                   
                    var categoriesData= result.categoriesData;
                    var seriesData = result.seriesData;

                    var rankMax = result.total_subjects;
                    var placeRank =  result.subject_rank;
                    var lineChartCategores =result.lineChartCategores;
                    var lineChartData = result.lineChartData;

                    Highcharts.chart('container-1', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'میزان بازدید بر اساس مرورگر'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        accessibility: {
                            point: {
                                valueSuffix: '%'
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                }
                            }
                        },
                        series: [{
                            name: 'درصد استفاده',
                            colorByPoint: true,
                            data: browserData
                        }]
                    });

                    Highcharts.chart('container-2', {
                        chart: {
                            type: 'pie',
                            // options3d: {
                            //     enabled: true,
                            //     alpha: 45
                            // }
                        },

                        title: {
                            text: 'میزان بازدید بر اساس دستگاه'
                        },
                        subtitle: {
                            text: 'نمودار دایره ای سه بعدی'
                        },
                        plotOptions: {
                            pie: {
                                innerSize: 100,
                                depth: 45
                            }
                        },
                        series: [{
                            name: 'تعداد بازدید',
                            data: deviceData
                        }]
                    });

                    Highcharts.chart('container-10', {
                        chart: {
                            type: 'pie',
                            // options3d: {
                            //     enabled: true,
                            //     alpha: 45
                            // }
                        },

                        title: {
                            text: '  میزان بازدید بر اساس گروهها در هفته جاری' 
                        },
                        subtitle: {
                            text: 'نمودار دایره ای سه بعدی'
                        },
                        plotOptions: {
                            pie: {
                                innerSize: 100,
                                depth: 45
                            }
                        },
                        series: [{
                            name: 'تعداد بازدید',
                            data: categoriesWeeklyVisitData
                        }]
                    });

                    Highcharts.chart('container-11', {
                        chart: {
                            type: 'pie',
                            // options3d: {
                            //     enabled: true,
                            //     alpha: 45
                            // }
                        },

                        title: {
                            text: '  میزان بازدید بر اساس گروهها در ماه جاری' 
                        },
                        subtitle: {
                            text: 'نمودار دایره ای سه بعدی'
                        },
                        plotOptions: {
                            pie: {
                                innerSize: 100,
                                depth: 45
                            }
                        },
                        series: [{
                            name: 'تعداد بازدید',
                            data: categoriesMonthlyVisitData
                        }]
                    });
                    

                    Highcharts.chart('container-3', {
                        chart: {
                            type: 'cylinder',
                            // options3d: {
                            //     enabled: true,
                            //     alpha: 15,
                            //     beta: 15,
                            //     depth: 50,
                            //     viewDistance: 25
                            // }
                        },
                        xAxis: {
                            categories: dailyVisitCategories,
                            labels: {
                                skew3d: true,
                                style: {
                                    fontSize: '16px'
                                }
                            }
                        },
                        yAxis: {
                            allowDecimals: false,
                            min: 0,
                            title: {
                                text: 'تعداد بازدید',
                                skew3d: true
                            }
                        },
                        title: {
                            text: 'بازدید در هفته اخیر'
                        },
                        plotOptions: {
                            series: {
                                depth: 25,
                                colorByPoint: true
                            }
                        },
                        series: [{
                            data: dailyVisitData,
                            name: 'بازدید',
                            showInLegend: false
                        }]
                    });

                    Highcharts.chart('container-4', {
                        chart: {
                            type: 'column',
                            // options3d: {
                            //     enabled: true,
                            //     alpha: 15,
                            //     beta: 15,
                            //     viewDistance: 25,
                            //     depth: 40
                            // }
                        },

                        title: {
                            text: 'بازدید در 6 ماه اخیر'
                        },

                        xAxis: {
                            categories: categoriesData,
                            labels: {
                                skew3d: true,
                                style: {
                                    fontSize: '16px'
                                }
                            }
                        },

                        yAxis: {
                            allowDecimals: false,
                            min: 0,
                            title: {
                                text: 'تعداد بازدید',
                                skew3d: true
                            }
                        },

                        tooltip: {
                            headerFormat: '<b>{point.key}</b><br>',
                            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
                        },

                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                depth: 40
                            }
                        },
                        series: seriesData
                    });

                    Highcharts.chart('container-5', {

                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false
                        },

                        title: {
                            text: 'رتبه در بین همه گروهها'
                        },

                        pane: {
                            startAngle: -150,
                            endAngle: 150,
                            background: [{
                                backgroundColor: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                        [0, '#FFF'],
                                        [1, '#333']
                                    ]
                                },
                                borderWidth: 0,
                                outerRadius: '109%'
                            }, {
                                backgroundColor: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                    stops: [
                                        [0, '#333'],
                                        [1, '#FFF']
                                    ]
                                },
                                borderWidth: 1,
                                outerRadius: '107%'
                            }, {
                                // default background
                            }, {
                                backgroundColor: '#DDD',
                                borderWidth: 0,
                                outerRadius: '105%',
                                innerRadius: '103%'
                            }]
                        },

                        // the value axis
                        yAxis: {
                            min: 1,
                            max: rankMax,

                            minorTickInterval: 'auto',
                            minorTickWidth: 1,
                            minorTickLength: 10,
                            minorTickPosition: 'inside',
                            minorTickColor: '#666',

                            tickPixelInterval: 30,
                            tickWidth: 2,
                            tickPosition: 'inside',
                            tickLength: 10,
                            tickColor: '#666',
                            labels: {
                                step: 1,
                                rotation: 'auto'
                            },
                            title: {
                                text: 'رتبه'
                            },
                            plotBands: [{
                                from: 1,
                                to: 300,
                                color: '#55BF3B' // green
                            }, {
                                from: 300,
                                to: 700,
                                color: '#DDDF0D' // yellow
                            }, {
                                from: 701,
                                to: 1000,
                                color: '#DF5353' // red
                            }]
                        },

                        series: [{
                            name: 'Rank',
                            data: [placeRank],
                            tooltip: {
                                valueSuffix: ' رتبه'
                            }
                        }]

                    });

                    Highcharts.chart('container-6', {
                        chart: {
                            type: 'line'
                        },
                        title: {
                            text: 'رتبه در شش ماه اخیر'
                        },
                        subtitle: {
                            text: 'منبع: hamgorooh.com'
                        },
                        xAxis: {
                            categories: lineChartCategores
                        },
                        yAxis: {
                            title: {
                                text: 'رتبه در سایت'
                            }
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: false
                            }
                        },
                        series: [{
                            name: 'رتبه در سایت',
                            data: lineChartData
                        }]
                    });

                },
                error: function () {

                    UnLoadElement('#statistics');
                }
            });
        }

    }


    // Create the chart



});


