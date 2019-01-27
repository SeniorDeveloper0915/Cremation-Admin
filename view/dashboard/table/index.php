<?php
session_start();
    include "../../../config/index.php";

    if (!isset($_SESSION['admin'])) {
        header('location:../../../index.php');
    }

    $getProject = $db->prepare("SELECT * FROM project");
    $getProject->execute();
    $rowProject = $getProject->fetchAll();

    $getDoctor = $db->prepare("SELECT * FROM doctor");
    $getDoctor->execute();
    $rowDoctor = $getDoctor->fetchAll();

    $getHospital = $db->prepare("SELECT * FROM hospital");
    $getHospital->execute();
    $rowHospital = $getHospital->fetchAll();

    $getQa = $db->prepare("SELECT * FROM qa");
    $getQa->execute();
    $rowQa = $getQa->fetchAll();
?>
    
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <title>Dashboard - Admin</title>
    <?php include '../../../include/css/mandatory/index.php' ?>
    <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/css/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css">

    <?php include '../../../include/css/global/index.php' ?>
    <style type="text/css">
        .info-box {
            display: block;
            min-height: 150px;
            background: #fff;
            width: 100%;
            box-shadow: 5px 10px 8px #888888;
            border-radius : 10px;
            margin-bottom: 15px;
            small {
                font-size: 14px;
            }
            .progress {
                background: rgba(0, 0, 0, .2);
                margin: 5px -10px 5px -10px;
                height: 2px;
                &,
                & .progress-bar {
                    .border-radius(0);
                }
                .progress-bar {
                    background: #fff;
                }
            }
        }
        .info-box-icon {
            display: block;
            float: left;
            height: 150px;
            max-height: 350px;
            width: 90px;
            text-align: center;
            font-size: 45px;
            line-height: 145px;
            border-radius: 10px;
        }

        .info-box-content {
            padding: 50px;
            margin-left: 90px;
        }

        .info-box-number {
            display: block;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<?php include '../../../include/header/index.php'; ?>
<div class="page-container">
    <?php include '../../../include/sidebar/index.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head margin-bottom-5">
                <div class="page-title">
                    <h1>
                        首页
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua" style="background: blue;">
                                    <i class="ion ion-steam"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-number"><?php echo count($rowProject) ?>
                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <small>个</small>
                                    </span>
                                    <span class="info-box-text">总整形项目数</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon" style="background: red;">
                                    <i class="ion ion-social-usd-outline"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-number">90
                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <small>篇</small>
                                    </span>
                                    <span class="info-box-text">总日记篇数</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon" style="background: rgb(255, 51, 255);">
                                    <i class="ion ion-android-person"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-number"><?php echo count($rowDoctor) ?>
                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <small>名</small>
                                    </span>
                                    <span class="info-box-text">总医生数量</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon" style="background: rgb(255, 153, 0);">
                                    <i class="ion ion-medkit"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-number"><?php echo count($rowHospital) ?>
                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <small>家</small>
                                    </span>
                                    <span class="info-box-text">总医院数量</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua" style="background: rgb(102, 204, 51);">
                                    <i class="ion ion-ios-help"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-number"><?php echo count($rowQa) ?>
                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <small>条</small>
                                    </span>
                                    <span class="info-box-text">总问答数</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon" style="background: rgb(255, 153, 204);">
                                    <i class="ion ion-document-text"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-number">90
                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <small>篇</small>
                                    </span>
                                    <span class="info-box-text">总攻略篇数</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--End modal -->
</div>
<!--End page-container-->
<?php include '../../../include/footer/index.php' ?>
<?php include '../../../include/footerjs/index.php' ?>

<!-- Start of plugins-->

<script src="../../../assets/plugins/flot/jquery.flot.js"></script>
<script src="../../../assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="../../../assets/plugins/flot/jquery.flot.resize.js"></script>
<script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../../assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>

<!-- End of plugins-->

<script>
    $(function () {

        var d1, d2, data, chartOptions;

        <?php
        // get array of dateswise signups
        $query = "SELECT date(`created_at`),count(*) as total,EXTRACT(DAY FROM created_at) AS  today
			       
			FROM `admin` WHERE
			MONTH(CURDATE()) = MONTH(created_at) AND YEAR(CURDATE()) = YEAR(created_at) 
			GROUP BY date(`created_at`)
			ORDER BY date(`created_at`) ASC;";

        $result = $db->prepare($query);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = "[{$row['today']},{$row['total']}]";

        }
        $date = date('t');

        // Assign to all dates if no date in array then ''
        for ($i = 1; $i <= $date; $i++) {
            if (isset($data[$i])) continue;
            $data[] = "[{$i}]";
        }
        // convert into array
        $d1data = implode(',', $data);
        ?>
        d1 = [
            <?php echo $d1data; ?>
        ];


        data = [{
            label: "Total Registration",
            data: d1
        }];

        chartOptions = {
            xaxis: {
                ticks: <?php echo date('t'); ?>,
                tickDecimals: 0
            },
            yaxis: {
                ticks: 11,
                tickDecimals: 0

            },

            series: {
                lines: {
                    show: true,
                    fill: false,
                    lineWidth: 3
                },
                points: {
                    show: true,
                    radius: 4.5,
                    fill: true,
                    fillColor: "#ffffff",
                    lineWidth: 2.75
                }
            },
            grid: {
                hoverable: true,
                clickable: false,
                borderWidth: 0
            },
            legend: {
                show: true
            },

            tooltip: true,
            tooltipOpts: {
                content: '%s: %y'
            },
            colors: App.chartColors
        };


        var holder = $('#line-chart');

        if (holder.length) {
            $.plot(holder, data, chartOptions);
        }


    });

</script>
</body>
</html>