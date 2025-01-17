<div class="page-content">
  <div class="page-heading">     
        <?php $this->load->view(ADMINFOLDER.'includes/menu_header');?>
    </div>
   

    <div class="container-fluid">
                                    
        <div data-widget-group="group1">
          <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default border-panel mb-md" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);z-index: 9;">
                  <div class="panel-heading filter-panel border-filter-heading" display-type="<?php if(isset($panelcollapsed) && $panelcollapsed==1){ echo "0"; } else{ echo "1";}?>">
                    <h2><?=APPLY_FILTER?></h2>
                    <div class="panel-ctrls" data-actions-container data-action-collapse="{&quot;target&quot;: &quot;.panelcollapse&quot;}" style="float:right;"><span class="button-icon has-bg"><span class="material-icons">keyboard_arrow_down</span></span></div>
                  </div>
                  <div class="panel-body panelcollapse pt-n" style="display: none;">
                    <form action="#" id="memberform" class="form-horizontal">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-3">
                            <div class="form-group">
                              <div class="col-md-12">
                                <label for="channelid" class="control-label">Channel</label>
                                <select id="channelid" name="channelid" class="selectpicker form-control" data-select-on-tab="true" data-size="5" title="All Channel" data-live-search="true" >
                                  <option value="">All Channel</option>
                                  <option value="0">Company</option>
                                  <?php foreach($channeldata as $cd){ ?>
                                    <option value="<?php echo $cd['id']; ?>"><?php echo $cd['name']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <div class="col-md-12">
                                <label for="status" class="control-label"><?=Member_label?></label>
                                <select id="memberid" name="memberid" class="selectpicker form-control" data-select-on-tab="true" data-size="5" data-live-search="true" >
                                  <option value="0">All <?=Member_label?></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group mt-xxl">
                              <div class="col-md-12">
                                <label class="control-label"></label>
                                <a class="<?=applyfilterbtn_class;?>" href="javascript:void(0)" onclick="applyFilter()" title=<?=applyfilterbtn_title?>><?=applyfilterbtn_text;?></a>
                              </div>
                            </div>
                          </div>
                        </div>
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
                      <?php 
                        if (strpos($submenuvisibility['submenuadd'],','.$this->session->userdata[base_url().'ADMINUSERTYPE'].',') !== false){
                      ?>
                      <a class="<?=addbtn_class;?>" href="<?php echo ADMIN_URL; ?>invoice-setting/invoice-setting-add" title=<?=addbtn_title?>><?=addbtn_text;?></a>
                      <?php
                        }if(strpos($submenuvisibility['submenudelete'],','.$this->session->userdata[base_url().'ADMINUSERTYPE'].',') !== false){
                      ?>
                      <a class="<?=deletebtn_class;?>" href="javascript:void(0)" onclick="checkmultipledelete('<?php echo ADMIN_URL; ?>invoice-setting/check-invoice-setting-use','Invoice setting','<?php echo ADMIN_URL; ?>invoice-setting/delete-mul-invoice-setting')" title=<?=deletebtn_title?>><?=deletebtn_text;?></a>
                      <?php } ?>
                  </div>
                </div>
                <div class="panel-body no-padding">
                  <div class="table-responsive">
                    <table id="invoicesettingtable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>            
                          <th class="width8">Sr.No.</th>
                          <th>Channel</th>
                          <th><?=Member_label?></th>
                          <th>Business Name</th>
                          <th class="width15">Business Address</th>
                          <th >Email</th>
                          <th>Logo</th>
                          <th>Invoice Notes</th>
                          <th class="width8">Action</th>
                          <th class="width5">
                            <div class="checkbox">
                              <input id="deletecheckall" onchange="allchecked()" type="checkbox" value="all">
                              <label for="deletecheckall"></label>
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="panel-footer"></div>
              </div>
            </div>
          </div>
        </div>
  
      </div>
</div> <!-- #page-content --> 


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 950px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="pagetitle"></h4>
      </div>
      <div class="modal-body">
          <div id="description"></div>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>