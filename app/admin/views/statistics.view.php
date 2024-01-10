<link href="<?php echo $HOST_NAME; ?>resources/plugins/tags/bootstrap-tagsinput.css" rel="stylesheet" />
<style>
	.center {
		position: absolute;
		left: 50%;
		top: 50%;
	}

	#myDiv {
		display: none;
		text-align: center;
	}
</style>
<style>
		#statistics * {
			direction: ltr !important;
		}

		.highcharts-figure,
		.highcharts-data-table table {
			/*        min-width: 320px;
        max-width: 800px;*/
			margin: 1em auto;
		}

		.highcharts-data-table table {
			font-family: IRANSansFa, sans-serif;
			border-collapse: collapse;
			border: 1px solid #EBEBEB;
			margin: 10px auto;
			text-align: center;
			/*      width: 100%;
        max-width: 500px;*/
		}

		.highcharts-data-table caption {
			padding: 1em 0;
			font-size: 1.2em;
			color: #555;
		}

		.highcharts-data-table th {
			font-weight: 600;
			padding: 0.5em;
		}

		.highcharts-data-table td,
		.highcharts-data-table th,
		.highcharts-data-table caption {
			padding: 0.5em;
		}

		.highcharts-data-table thead tr,
		.highcharts-data-table tr:nth-child(even) {
			background: #f8f8f8;
		}

		.highcharts-data-table tr:hover {
			background: #f1f7ff;
		}


		input[type="number"] {
			min-width: 50px;
		}
	</style>

<div class="loading-div" id="loader"></div>
<!-- Content Wrapper. Contains page content -->
<!-- Main Header Groups -->

<div class="main-header">
	<div class="content-bg-wrap bg-group"></div>
	<div class="container">
		<div class="row">
			<div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
				<div class="main-header-content">
					<h3>آمار بازدید سایت</h3>
					<p> وضعیت کلی سایت از این قسمت قابل بررسی می باشد </p>
				</div>
			</div>
		</div>
	</div>

	<img class="img-bottom" src="<?= $HOST_NAME?>/resources/assets/img/group-bottom.png" alt="friends">
</div>

<!-- ... end Main Header Groups -->

<div class="container">
	<div class="row">

		<div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
			<div class="ui-block">
				<div class="ui-block-content">
					<ul class="statistics-list-count">
						<li>
							<div class="points">
								<span>
									تعداد بازدید ماه قبل
								</span>
							</div>
							<div class="count-stat">
								<span id="last_month_visit"></span>
								<span id="last_month_visit_changes" class="indicator "> </span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
			<div class="ui-block">
				<div class="ui-block-content">
					<ul class="statistics-list-count">
						<li>
							<div class="points">
								<span>
									تعداد بازدید 6 ماه گذشته
								</span>
							</div>
							<div class="count-stat">
							 	<span id="last_6month_visit"></span>
								<span id="last_6month_visit_changes" class="indicator negative"> </span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
			<div class="ui-block">
				<div class="ui-block-content">
					<ul class="statistics-list-count">
						<li>
							<div class="points">
								<span>
									تعداد پستها در ماه قبل
								</span>
							</div>
							<div class="count-stat">
							    <span id="last_month_posts"></span>
								<span id="last_month_posts_changes" class="indicator "> </span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
			<div class="ui-block">
				<div class="ui-block-content">
					<ul class="statistics-list-count">
						<li>
							<div class="points">
								<span>
									تعداد پستها در 6 ماه گذشته
								</span>
							</div>
							<div class="count-stat">
								<span id="last_6month_posts"></span>
								<span id="last_6month_posts_changes" class="indicator positive"> </span>

							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="container">

	<div class="row" id="statistics">

		<form>
			<input type="hidden" id="sId" value="123" />
			<input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
		</form>

		<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
			<figure class="highcharts-figure" style="width:100%;">
				<div id="container-1"></div>
				<p class="highcharts-description">

					بر اساس مرورگر
				</p>
			</figure>
		</div>
		<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
			<figure class="highcharts-figure" style="width:100%;">
				<div id="container-2"></div>
				<p class="highcharts-description">

					براساس دستگاه
				</p>
			</figure>
		</div>

		<hr />
		<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
			<figure class="highcharts-figure" style="width:100%;">
				<div id="container-10"></div>
				<p class="highcharts-description">

					بر اساس موضوعات  در هفته جاری
				</p>
			</figure>
		</div>
		<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
			<figure class="highcharts-figure" style="width:100%;">
				<div id="container-11"></div>
				<p class="highcharts-description">

				بر اساس موضوعات  در ماه جاری
				</p>
			</figure>
		</div>

		<hr />
		<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
			<figure class="highcharts-figure" style="width:100%;">
				<div id="container-3"></div>
				<p class="highcharts-description">

					بازدید در هفته اخیر
				</p>
			</figure>
		</div>
		<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
			<figure class="highcharts-figure" style="width:100%;">
				<div id="container-4"></div>
				<p class="highcharts-description">
                		بازدید در 6 ماه اخیر
            	</p>
        		</figure>
		</div>



	</div>

</div>

<!-- /.content-wrapper -->
<script>
	var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>

<!-- <script type="text/javascript" src="<?php echo $HOST_NAME; ?>resources/plugins/highcharts-4.2.5/highcharts.js"></script>
<script type="text/javascript" src="<?php echo $HOST_NAME; ?>resources/plugins/highcharts-4.2.5/highcharts-more.js"></script>
<script type="text/javascript" src="<?php echo $HOST_NAME; ?>resources/plugins/highcharts-4.2.5/highcharts-3d.js"></script>
<script type="text/javascript" src="<?php echo $HOST_NAME; ?>resources/plugins/highcharts-4.2.5/modules/exporting.js"></script> -->

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/statistics.js"></script>