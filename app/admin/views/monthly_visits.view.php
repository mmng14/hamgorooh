<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="ui-block responsive-flex">

                        <form  name="frmMonthlyVisit" id="frmMonthlyVisit" role="form" method="post">
                            <div class="ui-block-title" style="border: 1px solid #aaa;">
                                <!-- <div class="h6 title"> محاسبه بازدید های ماهیانه گروهها </div> -->

                                <div class="block-btn align-right">
                                    <button type="submit" id="save" name="save" class="btn btn-success btn-send" value=""> محاسبه بازدید های ماهیانه </button>
                                </div>

                                <?php if (isset($msg)) echo $msg; ?>


                                <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />

                                <div class="block-btn align-right">
                                    <label> : انتخاب موضوع </label>
                                    <select id="this_subject_id" name="this_subject_id"  class="selectpicker form-control " aria-controls="sample_1">
                                        <option value="">انتخاب نمایید</option>
                                        <?php foreach( $subject_list as $subject): ?>
                                        <option value="<?= $subject["id"] ?>"><?= $subject["name"] ?></option>
                                        <?php endforeach ?>

                                    </select>
                                </div>

                                <div class="block-btn align-right">
                                    <label> : انتخاب سال </label>
                                    <select id="calcYear" name="calcYear"  class="selectpicker form-control " aria-controls="sample_1">
                                        <option value="">انتخاب نمایید</option>
                                        <option value="1400">1400</option>
                                        <option value="1401">1401</option>
                                        <option value="1402">1402</option>
                                        <option value="1403">1403</option>
                                        <option value="1404">1404</option>
                                        <option value="1405">1405</option>
                                        <option value="1406">1406</option>
                                        <option value="1407">1407</option>
                                        <option value="1408">1408</option>
                                        <option value="1409">1409</option>
                                        <option value="1410">1410</option>
                                        <option value="1411">1411</option>


                                    </select>
                                </div>

                                <div class="block-btn align-right">
                                    <label> : انتخاب ماه </label>
                                    <select id="calcMonth" name="calcMonth"  class="selectpicker form-control" aria-controls="sample_1">
                                        <option value="">انتخاب نمایید</option>
                                        <option value="01">فروردین</option>
                                        <option value="02">اردیبهشت</option>
                                        <option value="03">خرداد</option>
                                        <option value="04">تیر</option>
                                        <option value="05">مرداد</option>
                                        <option value="06">شهریور</option>
                                        <option value="07">مهر</option>
                                        <option value="08">آبان</option>
                                        <option value="09">آذر</option>
                                        <option value="10">دی</option>
                                        <option value="11">بهمن</option>
                                        <option value="12">اسفند</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">بازدید های ماهیانه گروهها </div>

                            <div class="block-btn align-right">
                           

                            </div>



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


    </div>
</div>
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/monthly_visits.js"></script>