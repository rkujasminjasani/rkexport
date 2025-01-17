<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gstr1_report extends Channel_Controller {

    public $viewData = array();
    function __construct(){
        parent::__construct();
        $this->viewData = $this->getChannelSettings('submenu', 'Gstr1_report');
        $this->load->model('Gstr1_report_model', 'Gstr1_report');
    }
    public function index() {
        $this->viewData['title'] = "GSTR1 Report";
        $this->viewData['module'] = "report/Gstr1_report";
        
        $MEMBERID = $this->session->userdata(base_url().'MEMBERID');
        $this->load->model('Channel_model', 'Channel');
        $this->viewData['channeldata'] = $this->Channel->getChannelListByMember($MEMBERID,'multiplesellerchannel');

        $this->channel_headerlib->add_javascript_plugins("bootstrap-datepicker","bootstrap-datepicker/bootstrap-datepicker.js");
        $this->channel_headerlib->add_javascript("gstr1_report", "pages/gstr1_report.js");
        $this->load->view(CHANNELFOLDER.'template',$this->viewData);
    }
    public function listing() {
        
        $this->load->model('Channel_model', 'Channel');
        $channeldata = $this->Channel->getChannelList('notdisplayguestorvendorchannel');
        $list = $this->Gstr1_report->get_datatables_channel();
        
        $data = array();       
        $counter = $_POST['start'];
        foreach ($list as $datarow) {         
            $row = array();
            $channellabel = "";

            if($datarow->sellerchannelid != 0){
                $key = array_search($datarow->sellerchannelid, array_column($channeldata, 'id'));
                if(!empty($channeldata) && isset($channeldata[$key])){
                    $channellabel = '<span class="label" style="background:'.$channeldata[$key]['color'].'">'.substr($channeldata[$key]['name'], 0, 1).'</span> ';
                }

                $membername = $channellabel.'<a href="'.CHANNEL_URL.'member/member-detail/'.$datarow->sellerid.'" title="'.ucwords($datarow->sellername).'" target="_blank">'.ucwords($datarow->sellername).' ('.$datarow->sellercode.')'.'</a>';
            }else{
                $membername = '<span class="label" style="background:#49bf88;">COMPANY</span>';
            }

            $row[] = ($datarow->gstno!=''?$datarow->gstno:'-');
            $row[] = $membername;
            $row[] = ucwords($datarow->cityname);
            $row[] = '<a href="'.CHANNEL_URL.'purchase-invoice/view-invoice/'.$datarow->invoiceid.'" title="View Invoice" target="_blank">'.$datarow->invoiceno.'</a>';
            $row[] = $this->general_model->displaydate($datarow->invoicedate);
            $row[] = number_format($datarow->invoicevalue,2,'.','');
            $row[] = ($datarow->placeofsupply!=''?ucwords($datarow->placeofsupply):'-');
            $row[] = number_format($datarow->reversecharge,2,'.','');
            $row[] = number_format($datarow->taxrate,2,'.','');
            $row[] = number_format($datarow->taxablevalue,2,'.','');
            $row[] = number_format($datarow->igst,2,'.','');
            $row[] = number_format($datarow->cgst,2,'.','');
            $row[] = number_format($datarow->sgst,2,'.','');

            $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Gstr1_report->count_all_channel(),
                        "recordsFiltered" => $this->Gstr1_report->count_filtered_channel(),
                        "data" => $data,
                        );
        echo json_encode($output);
    }

    public function exporttoexcelgstr1report(){
        
        $exportdata = $this->Gstr1_report->exportgstr1reportinchannel();
        
        
        $data = array();
        $srno = 0;
        $totaltaxablevalue = $totaligst = $totalcgst = $totalsgst = 0;
        foreach ($exportdata as $row) {         
            
            if($row->sellerchannelid != 0){
                $membername = ucwords($row->sellername).' ('.$row->sellercode.')';
            }else{
                $membername = 'COMPANY';
            }

            $taxablevalue = number_format($row->taxablevalue,2,'.','');
            $totaltaxablevalue += $taxablevalue;
            
            $igst = number_format($row->igst,2,'.','');
            $totaligst += $igst;

            $cgst = number_format($row->cgst,2,'.','');
            $totalcgst += $cgst;

            $sgst = number_format($row->sgst,2,'.','');
            $totalsgst += $sgst;
            
            $data[] = array(++$srno,
                            ($row->gstno!=''?$row->gstno:'-'),
                            $membername,
                            ucwords($row->cityname),
                            $row->invoiceno,
                            $this->general_model->displaydate($row->invoicedate),
                            numberFormat($row->invoicevalue,2,','),
                            ($row->placeofsupply!=''?ucwords($row->placeofsupply):'-'),
                            numberFormat($row->reversecharge,2,','),
                            numberFormat($row->taxrate,2,','),
                            numberFormat($row->taxablevalue,2,','),
                            numberFormat($row->igst,2,','),
                            numberFormat($row->cgst,2,','),
                            numberFormat($row->sgst,2,',')   
                        );
        }
        
        $total[] = array('','','','','','','','','','Total',numberFormat($totaltaxablevalue,2,','),numberFormat($totaligst,2,','),numberFormat($totalcgst,2,','),numberFormat($totalsgst,2,','));
        $result = array_merge($data,$total);
            
        $headings = array('Sr. No.','GST No.',Member_label.' Name','City Name','Invoice No.','Invoice Date','Invoice Value','Place of Supply','Reverse Charge','Tax Rate','Taxable Value','Integrated to (IGST)','Central to (CGST)','State/UT to (SGST)'); 
        $this->general_model->exporttoexcel($result,"A1:N1","GSTR1 Report",$headings,"GSTR1-Report.xls",array("G","I:N"),1);
    }

    public function exporttopdfgstr1report(){
        
        $PostData = $this->input->get();

        $PostData['heading'] = "B2B Section";
        $PostData['reportdata'] = $this->Gstr1_report->exportgstr1reportinchannel();
        $PostData['invoicesettingdata'] = $this->general_model->getShipperDetails();

        $header = $this->load->view(ADMINFOLDER . 'Companyheader', $PostData, true);
        $html = $this->load->view(CHANNELFOLDER . 'report/Printgstr1reportformat', $PostData, true);
        
        $this->load->library('m_pdf');
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();

        // Set a simple Footer including the page number
        $pdf->setFooter('Side {PAGENO} 0f {nb}');

        //this the the PDF filename that user will get to download

        $filename = "GSTR1-Report.pdf";
        $pdfFilePath = $filename;

        $pdf->AddPage(
            '', // L - landscape, P - portrait 
            '',
            '',
            '',
            '',
            10, // margin_left
            10, // margin right
            40, // margin top
            15, // margin bottom
            3, // margin header
            10
        ); // margin footer

        $this->load->model('Common_model');
        $stylesheet = $this->Common_model->curl_get_contents(ADMIN_CSS_URL . 'bootstrap.min.css'); // external css
        $stylesheet2 = $this->Common_model->curl_get_contents(ADMIN_CSS_URL . 'styles.css'); // external css
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->WriteHTML($stylesheet2, 1);
        $pdf->SetHTMLHeader($header, '', true);
        $pdf->WriteHTML($html, 0);

        ob_start();
        ob_end_clean();

        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, "D");
    }
    public function printGSTR1Report(){
        $this->checkAdminAccessModule('submenu','view',$this->viewData['submenuvisibility']);
        $PostData = $this->input->post();
        
        $PostData['reportdata'] =$this->Gstr1_report->exportgstr1reportinchannel();
        $PostData['invoicesettingdata'] = $this->general_model->getShipperDetails();
        $PostData['heading'] = "B2B Section";
        
        $html['content'] = $this->load->view(CHANNELFOLDER."report/Printgstr1reportformat.php",$PostData,true);
        echo json_encode($html); 
    }
}