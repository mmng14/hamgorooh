<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title"> اطلاعات تماس</div>
                           
                            <div class="block-btn align-right">
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-md-2" onclick="clearForm();">افزودن +</a>

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

                    <div class="ui-block responsive-flex" id="results">
                        <div class="loading-div" id="loader"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Window-popup Create Photo Album -->

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">افزودن</h4>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" name='frmContactInfo' id="frmContactInfo" role="form" method="post">
                            <input type="hidden" id="hashId" name="hashId" style="display:none;" />
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                            <div class="form-group">
                                <label class="control-label">کشور</label>

                                <input type="text" class="form-control" name="country" id="country">

                            </div>
                            <div class="form-group">
                                <label class="control-label">آدرس</label>

                                <textarea class="form-control" name="address" id="address" cols="45" rows="3" style="resize:none"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="latitude" class="control-label">عرض جغرافیایی</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="latitude" id="latitude">

                            </div>
                            <div class="form-group">
                                <label for="longitude" class="control-label" >طول جغرافیایی</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="longitude" id="longitude">

                            </div>
                            <div class="form-group">
                                <label class="control-label">موبایل</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="mobile" id="mobile">

                            </div>
                            <div class="form-group">
                                <label class="control-label">تلفن</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="telephones" id="telephones">

                            </div>
                            <div class="form-group">
                                <label class="control-label">فکس</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="fax" id="fax">

                            </div>
                            <div class="form-group">
                                <label class="control-label">ایمیل</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="email" id="email">

                            </div>
                            <div class="form-group">
                                <label class="control-label">فیس بوک</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="facebook" id="facebook">

                            </div>
                            <div class="form-group">
                                <label class="control-label">توییتر</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="twitter" id="twitter">

                            </div>
                            <div class="form-group">
                                <label class="control-label">گوگل پلاس</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="google_plus" id="google_plus">

                            </div>
                            <div class="form-group">
                                <label class="control-label">اینستاگرام</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="instagram" id="instagram">

                            </div>
                            <div class="form-group">
                                <label class="control-label">لینکدین</label>

                                <input type="text" class="form-control text-center" style="direction: ltr;" name="linkedin" id="linkedin">

                            </div>

                            <div class="form-group">
                            <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" id="status" class="checkboxes" value="1">
                                        وضعیت
                                    </label>
                                </div>
                            </div>

                            <!-- <button type="submit" id="save" name="save" class="btn btn-green btn-send" value="" >ذخیره</button>
                            <button class="btn btn-danger" data-dismiss="modal">بستن</button>
                            -->
                            <button type="submit" id="save" name="save" class="btn btn-green btn-md btn-send">ذخیره</button>
                            <button class="btn btn-grey btn-md" data-dismiss="modal">بستن</button>

                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- ... end Window-popup Create Photo Album -->
    </div>
</div>
<!-- /.content-wrapper -->

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/contact_info.js"></script>