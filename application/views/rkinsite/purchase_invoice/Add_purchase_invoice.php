<script type="text/javascript">
	
</script>
<div class="page-content">
    <div class="page-heading">            
        <h1><?php if(isset($invoicedata)){ echo 'Edit'; }else{ echo 'Add'; } ?>  <?=$this->session->userdata(base_url().'submenuname');?></h1>
        <small>
          	<ol class="breadcrumb">                        
            <li><a href="<?php echo base_url(); ?><?php echo ADMINFOLDER; ?>dashboard">Dashboard</a></li>
            <li><a href="javascript:void(0)"><?php echo $this->session->userdata(base_url().'mainmenuname'); ?></a></li>
            <li><a href="<?php echo base_url().ADMINFOLDER; ?><?=$this->session->userdata(base_url().'submenuurl')?>"><?php echo $this->session->userdata(base_url().'submenuname'); ?></a></li>
            <li class="active"><?php if(isset($invoicedata)){ echo 'Edit'; }else{ echo 'Add'; } ?> Purchase <?php echo $this->session->userdata(base_url().'submenuname'); ?></li>
          	</ol>
        </small>
    </div>

    <div class="container-fluid">
      	<div data-widget-group="group1">
		  <div class="row">
		    <div class="col-md-12">
		      <div class="panel panel-default border-panel">
		        <div class="panel-body pt-n">
		        	<div class="col-md-12">
                    <?php $this->load->view(ADMINFOLDER.'purchase_invoice/purchaseinvoiceformat');?>
					</div>
				</div>
		      </div>
		    </div>
		  </div>
		</div>
    </div> <!-- .container-fluid -->
</div> <!-- #page-content -->
