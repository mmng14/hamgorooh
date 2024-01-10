<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker-default.css">
<script src="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker.min.js"></script>
<!-- Content Wrapper. Contains page content -->

<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">ریپورتاژ</div>

                            <div class="block-btn align-right">
                                <!-- <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-md-2">افزودن +</a> -->

                            </div>
                            <?php if (isset($msg)) echo $msg; ?>

                            <div class="block-btn align-right">
                                <label> : مرتب سازی </label>
                                <select id="cmbsort" name="cmbsort" onChange="loadData();" class="selectpicker form-control " aria-controls="sample_1">
                                    <option value="1">قدیمی تر</option>
                                    <option value="2">جدید تر</option>
                                </select>
                            </div>
                            <div class="block-btn align-right">
                                <label> : تعداد سطرها </label>
                                <select id="cmbnumberPage" name="cmbnumberPage" onChange="loadData();" class="selectpicker form-control" aria-controls="sample_1">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                            </div>
                            <input type="hidden" id="_csrf" name="_csrf"
                               value="<?php echo $_csrf; ?>"/>

                            <a href="#" class="more"><svg class="olymp-three-dots-icon">
                                    <use xlink:href="#olymp-three-dots-icon"></use>
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Tab panes -->
                    <div class="loading-div" id="loader"></div>
                    <div class="ui-block responsive-flex" id="results">
                       
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.content-wrapper -->

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/group_admin/scripts/reportage.js"></script>