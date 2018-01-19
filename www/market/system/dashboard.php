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
$rdp = "";
  $sql = "SELECT t1.username, t1.EmailAddress,  t3.Name, t3.Reg_No,t1.M_Company_Id FROM `m_user` t1 INNER JOIN `m_company` t3 ON t3.id = t1.M_Company_Id  where t1.id = ".$userid;

  $result = $conn->query($sql);
if (isset($result)){
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $username = $row["username"];
      $email =  $row["EmailAddress"];
      $company_name = $row["Name"];
      $company_id = $row["M_Company_Id"];
      $reg_no = $row["Reg_No"];
    }
  }
}
$count_rfq_draft = 0;
$count_rfq_submitted = 0;
$count_rfq_awarded = 0;
$count_quotation_count = 0;

$count_quotation_submitted = 0;
$count_quotation_approved = 0;
$count_quotation_rejected = 0;
if(($_SESSION['usertype'] == 'Buyer')){
  $sql = "SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_RfqStatus Where C_DocumentType = 6 and t1.C_RfqStatus = 9 and t1.M_User_Id = ". $userid;
  $result = $conn->query($sql);
  $count_rfq_draft = $result->num_rows;

  $sql = "SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_RfqStatus Where C_DocumentType = 6 and t1.C_RfqStatus = 10 and t1.M_User_Id = ". $userid;
  $result = $conn->query($sql);
  $count_rfq_submitted = $result->num_rows;

  $sql = "SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_RfqStatus Where C_DocumentType = 6 and t1.C_RfqStatus = 12 and t1.M_User_Id = ". $userid;
  $result = $conn->query($sql);
  $count_rfq_awarded = $result->num_rows;

  $sql ="SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_QuotationStatus Where t1.Status = 1 and C_DocumentType = 7 and t1.C_QuotationStatus in (16,17,18,19,20) and t1.DocumentNo in (SELECT DocumentNo From t_document Where Status = 1 and C_DocumentType = 6 and M_User_Id = ". $userid.")";
  $result = $conn->query($sql);
  $count_quotation_count = $result->num_rows;
}elseif(($_SESSION['usertype'] == 'Supplier')){
  $sql = $query = "SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_QuotationStatus Where t1.Status = 1 and C_DocumentType = 7 and t1.C_QuotationStatus in (16) and t1.M_User_Id = ". $userid;
  $result = $conn->query($sql);
  $count_quotation_submitted = $result->num_rows;

  $sql = $query = "SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_QuotationStatus Where t1.Status = 1 and C_DocumentType = 7 and t1.C_QuotationStatus in (18) and t1.M_User_Id = ". $userid;
  $result = $conn->query($sql);
  $count_quotation_approved = $result->num_rows;

  $sql = $query = "SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_QuotationStatus Where t1.Status = 1 and C_DocumentType = 7 and t1.C_QuotationStatus in (19) and t1.M_User_Id = ". $userid;
  $result = $conn->query($sql);
  $count_quotation_rejected = $result->num_rows;

  $sql = $query = "SELECT t1.Id, t1.DocumentNo, t1.Title, t1.CreatedDate, t2.Name as Status FROM t_document t1 Inner Join c_codetable t2 on t2.Id = t1.C_RfqStatus Inner Join t_targetedsuppliers t3 on t3.T_Document_Id = t1.Id Where C_DocumentType = 6 and t3.M_Company_Id = ". $company_id;
  $result = $conn->query($sql);
  $count_rfq_invited = $result->num_rows;


}
	$sql = "SELECT t1.username, t1.EmailAddress, t3.Name, t3.Reg_No,t1.M_Company_Id FROM `m_user` t1 INNER JOIN `m_company` t3 ON t3.id = t1.M_Company_Id  where t1.id = ".$userid;
    $result = $conn->query($sql);
	if (isset($result)){
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$username = $row["username"];
				$email =  $row["EmailAddress"];
				$company_name = $row["Name"];
				$reg_no = $row["Reg_No"];
				$M_Company_Id = $row["M_Company_Id"];
			}
		}
	}
	?>

 <!-- Main content -->
      <section class="content">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Dashboard
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php
                if(($_SESSION['usertype'] == 'Buyer')){

                echo '<h3>'.$count_rfq_draft.'</h3>';
                echo '<p>RFQ Draft</p>';

                }elseif(($_SESSION['usertype'] == 'Supplier')){
                  echo '<h3>'.$count_rfq_invited.'</h3>';
                  echo '<p>RFQ Invited</p>';
                }
              ?>

            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="index.php?rdp=list_rfq" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                if(($_SESSION['usertype'] == 'Buyer')){
                  $rdp = 'list_rfq';
                echo '<h3>'.$count_rfq_submitted.'</h3>';
                echo '<p>RFQ Submitted</p>';


                }elseif(($_SESSION['usertype'] == 'Supplier')){
                    $rdp = 'list_quotation';
                  echo '<h3>'.$count_quotation_submitted.'</h3>';
                  echo '<p>Quotation Submitted</p>';
                }
              ?>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="index.php?rdp=<?php echo $rdp; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php
                if(($_SESSION['usertype'] == 'Buyer')){
                  $rdp = 'list_rfq';
                echo '<h3>'.$count_rfq_awarded.'</h3>';
                echo '<p>RFQ Awarded</p>';


                }elseif(($_SESSION['usertype'] == 'Supplier')){
                    $rdp = 'list_quotation';
                  echo '<h3>'.$count_quotation_approved.'</h3>';
                  echo '<p>Quotation Approved</p>';
                }
              ?>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="index.php?rdp=<?php echo $rdp; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php
                if(($_SESSION['usertype'] == 'Buyer')){
                  $rdp = 'list_quotation';
                echo '<h3>'.$count_quotation_count.'</h3>';
                echo '<p>Quotation Submitted</p>';


                }elseif(($_SESSION['usertype'] == 'Supplier')){
                    $rdp = 'list_quotation';
                  echo '<h3>'.$count_quotation_rejected.'</h3>';
                  echo '<p>Quotation Rejected</p>';
                }
              ?>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="index.php?rdp=<?php echo $rdp; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

    </section>


      </section>
      <!-- /.content -->
