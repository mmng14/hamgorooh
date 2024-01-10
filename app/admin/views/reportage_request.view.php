<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker-default.css">
<script src="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <!-- Main content -->
        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <h4>درخواست رپرتاژ</h4>
                            <div class="block-btn align-right">
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-md-2" onclick="clearForm();">افزودن +</a>
                            </div>

                            <?php if (isset($msg)) echo $msg; ?>

                            <div class="block-btn align-right">
                                <label>مرتب سازی : </label>
                                <select id="cmbsort" name="cmbsort" onchange="loadData();" class="form-control selectpicker" aria-controls="sample_1">
                                    <option value="1">قدیمی تر</option>
                                    <option value="2">جدید تر</option>
                                </select>
                            </div>
                            <div class="block-btn align-right">
                                <label>تعداد سطرها : </label>
                                <select id="cmbnumberPage" name="cmbnumberPage" onchange="loadData();" class="form-control selectpicker" aria-controls="sample_1">
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
                    <div id="results" class="ui-block responsive-flex">

                        <div class="loading-div" id="loader"></div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title">افزودن</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">

                            <div id="imageSelectBox" class="col-md-12 callout-warning text-center">

                                <img id="uploadImage" width="200" height="120" />

                                <label for="upload" class="btn btn-primary text-center upload-lable-btn">انتخاب
                                    فایل</label>
                                <input type="file" name="upload" id="upload" class="post-file-upload" />
                                <input type="hidden" name="file_address" id="file_address" value="" />
                            </div>
                            فایل باید با یکلی از پسنوندهای zip یا rar ارسال شود.

                        </div>


                        <form enctype="multipart/form-data" name="formReportage" id="formReportage" role="form" method="post">

                            <input type="hidden" id="hashId" name="hashId" style="display: none;" />
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />


                            <div class="form-group">
                                <label class="control-label">سایت مورد نظر</label>

                                <select class="form-control" id="subjectId" name="subjectId">
                                    <option value="0"> سایت اصلی همگروه</option>
                                    <?php foreach ($subject_sites as $subject_site) : ?>
                                        <option value="<?= $subject_site['subject_id'] ?>"><?= $subject_site['site_link'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="form-group">
                                <label class="control-label">قیمت</label>

                                <input type="text" readonly class="form-control" name="price" id="price">

                            </div>

                            <div class="form-group">
                                <label class="control-label">آدرس سایت</label>

                                <input type="text" class="form-control" style="direction: ltr;" name="back_link_address" id="back_link_address">

                            </div>

                            <div class="form-group">
                                <label class="control-label">نام سایت</label>

                                <input type="text" class="form-control" style="direction: ltr;" name="back_link_name" id="back_link_name">

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="post_id">شناسه پست</label>

                                <input type="text" class="form-control" style="direction: ltr;" name="post_id" id="post_id">

                            </div>
                            <div class="form-group">
                                <label class="control-label" for="reportage_link">آدرس رپرتاژ</label>

                                <input type="text" class="form-control" style="direction: ltr;" name="reportage_link" id="reportage_link">

                            </div>
                            <div class="form-group">
                                <label class="control-label">توضیحات</label>

                                <textarea name="description" id="description" class="form-control" cols="6" rows="3" style="resize: none"></textarea>

                            </div>


<!-- 
                            <button type="submit" id="save" name="save" class="btn btn-green btn-send" value="" >ذخیره</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">بستن
                            </button> -->
                            <button type="submit" id="save" name="save" class="btn btn-green btn-md btn-send">ذخیره</button>
                            <button class="btn btn-grey btn-md" data-dismiss="modal">بستن</button>

                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /.modal -->
    <!-- /.content-wrapper -->
    <script>
        var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
    </script>
    <script src="<?php echo $HOST_NAME; ?>app/admin/scripts/reportage_request.js"></script>