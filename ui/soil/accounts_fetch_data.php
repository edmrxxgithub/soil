<?php 
include_once 'connectdb.php';

function fetch_total_paid($pdo,$id)
{

	$select = $pdo->prepare("SELECT SUM(amount) as total_paid FROM tb_account_supplier_payment where account_supplier_data_id = '$id' ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);

	return $row->total_paid;
}


$id = $_POST['id'];


$select = $pdo->prepare("SELECT * FROM tb_account_supplier_data where id = '$id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$total = $row->qty * $row->price;


$total_paid = fetch_total_paid($pdo,$row->id);
$outstanding_balance = $total - $total_paid;

?>


<table class="table table-bordered" border="1" width="100%">
	<thead>
		<tr>
			<td width="25%">Date&nbsp;:</td>
			<td><?= $row->date ?></td>
		</tr>
		<tr>
			<td width="25%">Invoice No.&nbsp;:</td>
			<td><?= $row->invoice_num ?></td>
		</tr>
		<tr>
			<td width="25%">Unit of measure / qty&nbsp;:</td>
			<td><?= $row->qty ?></td>
		</tr>
		<tr>
			<td width="25%">Price&nbsp;:</td>
			<td><?= number_format($row->price,2) ?></td>
		</tr>
		<tr>
			<td width="25%">Total&nbsp;:</td>
			<td><?= number_format($total,2) ?></td>
		</tr>
		<tr>
			<td width="25%">Total&nbsp;:</td>
			<td class="text-danger"><?= number_format($outstanding_balance,2) ?></td>
		</tr>
	</thead>
</table>


<button class="btn btn-primary btn-sm text-white" title="View" data-id='<?= $id ?>' id="pay_payables">
	<span class="fa fa-plus"></span>&nbsp;Pay
</button>


<table class="table table-bordered mt-3" border="1" width="100%">
	<thead>
		<tr>
			<!-- <td align="center" style="font-weight:bold;">#</td> -->
			<td align="center" style="font-weight:bold;">Date</td>
			<td align="center" style="font-weight:bold;">Reference No.</td>
			<td align="center" style="font-weight:bold;">Amount</td>
			<td align="center" style="font-weight:bold;">Delete</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 1;
		$totalamount = 0;
		$select = $pdo->prepare("SELECT * FROM tb_account_supplier_payment where account_supplier_data_id = '$id' ");
		$select->execute();
		while($row = $select->fetch(PDO::FETCH_OBJ))
		{
			$totalamount += $row->amount;
		?>
		<tr>	
			<!-- <td align="center"><?= $row->id ?></td> -->
			<td align="center"><?= $row->date ?></td>
			<td align="center"><?= $row->reference_num ?></td>
			<td align="center"><?= number_format($row->amount,2) ?></td>
			<td align="center">

				<button class="btn btn-danger btn-sm text-white" title="Delete" data-id='<?= $row->id ?>' id="delete_payables">
					<span class="fa fa-trash"></span>
				</button>

			</td>
		</tr>
		<?php
			$i++;
		}
		?>

		<tr>	
			<!-- <td align="center"></td> -->
			<td align="center"></td>
			<td align="center" style="font-weight:bold;">Total</td>
			<td align="center" style="font-weight:bold;" class="text-success"><?= number_format($totalamount,2) ?></td>
			<td align="center"></td>
		</tr>

	</tbody>
</table>










