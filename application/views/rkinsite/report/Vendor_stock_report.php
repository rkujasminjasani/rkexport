<style>
  .vendorid .dropdown-menu, .batchno .dropdown-menu{
    width: max-content;
  }
</style>
<div class="page-content">
    <div class="page-heading">     
        <?php $this->load->view(ADMINFOLDER.'includes/menu_header');?>
    </div>

    <div class="container-fluid">
                                    
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
             <div class="panel panel-default border-panel mb-md" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);z-index: 9;">
                <div class="panel-heading filter-panel border-filter-heading">
                    <h2><?=APPLY_FILTER?></h2>
                    <div class="panel-ctrls" data-actions-container data-action-collapse="{&quot;target&quot;: &quot;.panelcollapse&quot;}" style="float:right;"><span class="button-icon has-bg"><span class="material-icons">keyboard_arrow_down</span></span></div>
                </div>
                <div class="panel-body panelcollapse pt-n" style="display: none;">
                  <form action="#" id="memberform" class="form-horizontal">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="col-sm-12 pr-xs">
                            <label for="startdate" class="control-label">Date</label>
                            <div class="input-daterange input-group" id="datepicker-range">
                              <input type="text" class="input-small form-control" name="startdate" id="startdate" value="<?php echo $this->general_model->displaydate(date("y-m-d",strtotime("-1 month"))); ?>" placeholder="Start Date" title="Start Date" readonly/>
                              <span class="input-group-addon">to</span>
                              <input type="text" class="input-small form-control" name="enddate" id="enddate" value="<?php echo $this->general_model->displaydate($this->general_model->getCurrentDate()); ?>" placeholder="End Date" title="End Date" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group" id="vendor_div">
                          <div class="col-sm-12 pl-xs pr-xs">
                              <label for="vendorid" class="control-label">Vendor</label>
                              <select id="vendorid" name="vendorid" class="selectpicker form-control vendorid" data-live-search="true" data-select-on-tab="true" data-size="8">
                                <option value="0">All Vendor</option>
                                <?php if(!empty($vendordata)){ foreach($vendordata as $vendor){ ?>
                                <option value="<?php echo $vendor['id']; ?>"><?php echo $vendor['name']; ?></option>
                                <?php }} ?>
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <div class="col-sm-12 pl-xs pr-xs">
                              <label for="productid" class="control-label">Product</label>
                              <select id="productid" name="productid" class="selectpicker form-control productid" data-live-search="true" data-select-on-tab="true" data-size="8">
                                <option value="0">All Product</option>
                                <?php if(!empty($productdata)){ foreach($productdata as $product){ 
                                   $productname = str_replace("'","&apos;",$product['name']);
                                   if(DROPDOWN_PRODUCT_LIST==0){ ?>
   
                                     <option value="<?php echo $product['id']; ?>"><?php echo $productname; ?></option>
   
                                   <?php }else{
   
                                     if($product['image']!="" && file_exists(PRODUCT_PATH.$product['image'])){
                                       $img = $product['image'];
                                     }else{
                                       $img = PRODUCTDEFAULTIMAGE;
                                     }
                                     ?>
   
                                     <option data-content="<?php if(!empty($product['image'])){?><img src='<?=PRODUCT.$img?>' style='width:40px'> <?php } echo $productname; ?> "  value="<?php echo $product['id']; ?>"><?php echo $productname; ?></option>
                                     
                                   <?php } ?>
                                <?php }} ?>
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <div class="col-sm-12 pl-xs">
                              <label for="batchno" class="control-label">Process Batch No.</label>
                              <select id="batchno" name="batchno" class="selectpicker form-control batchno" data-live-search="true" data-select-on-tab="true" data-size="8">
                                <option value="">All Batch No.</option>
                                <?php if(!empty($batchnodata)){ foreach($batchnodata as $batch){ ?>
                                <option value="<?php echo $batch['id']; ?>"><?php echo $batch['batchno']; ?></option>
                                <?php }} ?>
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <div class="col-sm-12 pl-xs mt-xl">
                            <a class="<?=applyfilterbtn_class;?>" href="javascript:void(0)" onclick="applyFilter()" title=<?=applyfilterbtn_title?>><?=applyfilterbtn_text;?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      
                    </div> 
                  </form>
                </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="panel panel-default border-panel">
              <div class="panel-heading">
                <div class="col-md-6">
                  <div class="panel-ctrls panel-tbl"></div>
                </div>
                <div class="col-md-6 form-group" style="text-align: right;">
                  <?php if (in_array("export-to-excel",$this->viewData['submenuvisibility']['assignadditionalrights'])){ ?>
                    <a class="<?=exportbtn_class;?>" href="javascript:void(0)" onclick="exporttoexcelvendorstockreport()" title="<?=exportbtn_title?>"><?=exportbtn_text;?></a>
                    <?php } if (in_array("export-to-pdf",$this->viewData['submenuvisibility']['assignadditionalrights'])){ ?>
                    <a class="<?=exportpdfbtn_class;?>" href="javascript:void(0)" onclick="exporttopdfvendorstockreport()" title="<?=exportpdfbtn_title?>"><?=exportpdfbtn_text;?></a>
                    <?php } if (in_array("print",$this->viewData['submenuvisibility']['assignadditionalrights'])){ ?>
                    <a class="<?=printbtn_class;?>" href="javascript:void(0)" onclick="printvendorstockreport()" title=<?=printbtn_title?>><?=printbtn_text?></a>
                  <?php } ?>
                </div>
              </div>
              <div class="panel-body no-padding">
                <table id="vendorstockreporttable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="width5">Sr. No.</th>
                      <th>Job Card</th> 
                      <th>Job Name</th> 
                      <th>Batch No.</th> 
                      <th>Vendor</th>
                      <th>Product</th>
                      <th>Price (<?=CURRENCY_CODE?>)</th>
                      <th>Qty</th>
                      <th>Total Amount (<?=CURRENCY_CODE?>)</th>
                      <th>Transaction Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div class="panel-footer"></div>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->