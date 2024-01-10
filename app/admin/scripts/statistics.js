$(document).ready(function () {

    LoadElement('#statistics');

    setTimeout(function () {

        StatisticsData();
    }, 2000);

    function StatisticsData() {

        var _csrf = $("#_csrf").val();
        var sId = $('#sId').val();

        if (sId !== '') {
            $.ajax({
                url: HOST_NAME + "admin/statistics/",
                type: "POST",
                data: { 
                    s_id: sId, 
                    _csrf: _csrf ,
                    check:"admin_statistics_op_code"
                },
                dataType: "json",
                traditional: true,
                success: function (result) {

                    UnLoadElement('#statistics');

                    $('#last_month_visit').html(result.last_month_visit_count);    
                    $('#last_month_visit_changes').html(result.last_month_visit_changes); 
                    $('#last_month_visit_changes').addClass(result.last_month_visit_changes_type); 
                    $('#last_6month_visit').html(result.last_6_month_visit_count);  
                    
                    $('#last_month_posts').html(result.last_month_post_count);    
                    $('#last_month_posts_changes').html(result.last_month_post_changes); 
                    $('#last_month_posts_changes').addClass(result.last_month_post_changes_type); 
                    $('#last_6month_posts').html(result.last_6_month_post_count);  

                    console.log(result);
                    var browserData = result.browserData;

                    var deviceData = result.deviceData;

                    var subjectsWeeklyVisitData = result.subjectsWeeklyVisitData;
                    var subjectsMonthlyVisitData = result.subjectsMonthlyVisitData;


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
                            name: 'Delivered amount',
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
                            text: '  میزان بازدید بر اساس موضوعات در هفته جاری' 
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
                            data: subjectsWeeklyVisitData
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
                            text: '  میزان بازدید بر اساس موضوعات در ماه جاری' 
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
                            data: subjectsMonthlyVisitData
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
                            text: 'بازدید  در هفته اخیر'
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

           

                },
                error: function () {

                    UnLoadElement('#statistics');
                }
            });
        }

    }


    // Create the chart



});


