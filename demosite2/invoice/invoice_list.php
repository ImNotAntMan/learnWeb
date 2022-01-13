<?php 
session_start();
include('inc/header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<title>견적서</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('inc/container.php');?>
	<div class="container">		
	  <h2 class="title">견적서 리스트</h2>
	  <?php include('menu.php');?>			  
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>만든날</th>
            <th>거래처</th>
            <th>견적가격</th>
            <th>출력</th>
            <th>수정</th>
            <th>삭제</th>
          </tr>
        </thead>
        <?php		
		    $invoiceList = $invoice->getInvoiceList();
        foreach($invoiceList as $invoiceDetails){
			    $invoiceDate = date("Y/M/d, H:i:s", strtotime($invoiceDetails["order_date"]));
            echo '
              <tr>
                <td>'.$invoiceDetails["order_id"].'</td>
                <td>'.$invoiceDate.'</td>
                <td>'.$invoiceDetails["order_receiver_name"].'</td>
                <td>'.$invoiceDetails["order_total_after_tax"].'</td>
                <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Invoice"><span class="glyphicon glyphicon-print"></span></a></td>
                <td><a href="edit_invoice.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Invoice"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="#" id="'.$invoiceDetails["order_id"].'" class="deleteInvoice"  title="Delete Invoice"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('inc/footer.php');?>