<!-- Content Wrapper. Contains page content -->
<div class="container">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="ui-block responsive-flex">
            <div class="ui-block-title">

              <h5>لیست پیامها</h5>
      
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
              <div class="block-btn align-right">
                <label>:عبارت جستجو </label>

                <input type="text" class="form-control input-sm" name="txtsearch" id="txtsearch" placeholder="جستجو">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>

              </div>
             

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <!-- Tab panes -->
          <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
          <div class="ui-block responsive-flex" id="results">
            <div class="loading-div" id="loader"></div>
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
<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/messages.js"></script>