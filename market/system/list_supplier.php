 <?php
	 include_once('lib/pdowrapper/class.pdowrapper.php');
	 $dbConfig = array("host" => $server, "dbname" => $database, "username" => $db_user, "password" => $db_pass);
	// get instance of PDO Wrapper object
	$db = new PdoWrapper($dbConfig);
    if(isset($_SESSION['userid'])){
		$userid = $_SESSION['userid'];
	}else{
		echo "no userid";
	}

?>
 <div class="row">
        <div class="col-sm-12">
            <h3>
                Supplier List
            </h3>
			<div id="notify" class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>

				<div class="message"></div>
			</div>
        </div>
    </div>


	<div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Suppliers</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="box-body">
              <table id="supplier_list" class="table table-bordered table-striped">
					<thead>
                        <tr>
                            <th>No.</th>
                            <th>Company Name</th>
							              <th>Registration No.</th>
                            <th>Address</th>
                            <th>Setting</th>
                          </tr>
						</thead>
						<tbody>
						<?php
						$query = "SELECT * FROM m_company Where Id in (Select M_Company_Id From m_user Where C_UserType = 2 And Status = 1)";
						$results = $db->pdoQuery($query)->results();
						if (!empty($results)){
							$count = 0;
							foreach ($results as $row) {
								$count = $count+1;
								?>
								<tr>
									<td><?php echo $count; ?></td>
									<td><?php echo $row["Name"];?></td>
									<td><?php echo $row["Reg_No"];?></td>
									<td><?php echo $row["Address"];?></td>
									<td><?php

						$out = '<a href="index.php?rdp=company_profile&companyid=' . $row["Id"] .'" class="btn btn-warning btn-xs"><span class="icon-pencil"></span>View</a> ';
						echo $out;
						?></td>
								</tr>

								<?php
							}
						}
						?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


	<script>
  $(function () {
    $('#supplier_list').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
	})
</script>
