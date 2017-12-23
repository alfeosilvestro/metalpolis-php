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
   
  $rfq_ref = "";
	if(isset($_GET["rfq_ref"])){
		$rfq_ref = $_GET["rfq_ref"];
	}
	
	
	$sql = "SELECT * FROM `t_document` t1 where Status = 1 and C_DocumentType = 6 and t1.DocumentNo = '".$rfq_ref."'";
    $result = $conn->query($sql);
	if (isset($result)){
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$rfq_id = $row["Id"];
			   $rfq_ref = $row["DocumentNo"];
			   $rfq_statusid = $row["C_RfqStatus"];
			   $rfq_userid = $row["M_User_Id"];
			   $rfq_createddate = $row["CreatedDate"];
			   $rfq_subject = $row["Title"];
			   $FName = $row["ContactPersonFName"];
			   $LName = $row["ContactPersonLName"];
			}
		
			
		
	
	$sql = "SELECT t1.FinalClosingDate, t1.PreferredPaymentTerms FROM `t_requestforquotation` t1 where t1.Document_Id = ".$rfq_id;
    $result = $conn->query($sql);
	if (isset($result)){
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$FinalClosingDate = $row["FinalClosingDate"];
				$PreferredPaymentTerms =  $row["PreferredPaymentTerms"];
			}
		}
	}
	
	$sql = "SELECT t1.username, t1.EmailAddress, t2.RfqCount, t3.Name, t3.Reg_No FROM `m_user` t1 INNER JOIN `m_buyer` t2 ON t1.id = t2.M_User_Id INNER JOIN `m_company` t3 ON t3.id = t1.M_Company_Id  where t1.id = ".$rfq_userid;
    $result = $conn->query($sql);
	if (isset($result)){
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$username = $row["username"];
				$email =  $row["EmailAddress"];
				$rfq_count = $row["RfqCount"];
				$company_name = $row["Name"];
				$reg_no = $row["Reg_No"];
			}
		}
	}
   
?>
 <div class="row">
        <div class="col-sm-12">
            <h3>
                Edit RFQ
            </h3>
			<div id="notify" class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>

				<div class="message"></div>
			</div>
        </div>
    </div>
	
 <form action="#" method="post" id="edit_rfq" >
 <div class="row">
   
        <div class="col-sm-12">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-success" id="btnsave_rfq_top" >Save as Draft</button>
                
                <button type="button" id="btnsubmit_rfq_top" class="btn btn-warning">Submit</button>
            </div>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">RFQ Info</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>RFQ Ref</label>
                        <input name="rfq_ref" type="text" readonly class="form-control" value="<?php echo $rfq_ref; ?>" >
						 <input name="rfq_id" type="hidden" readonly class="form-control" value="<?php echo $rfq_id; ?>" >
						 <input name="user_id" type="hidden" readonly class="form-control" value="<?php echo $userid; ?>" >
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input name="company_name" type="text" readonly class="form-control"
                               value="<?php echo $company_name; ?>">
                    </div>
                    <div class="form-group">
                        <label>Contact Person First Name</label>
                        <input name="first_name" type="text" class="form-control" value="<?php echo $FName; ?>" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <label>RFQ Date</label>
                        
						<div class="input-group date col-sm-5">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="rfq_date" class="form-control pull-right" id="rfq_datepicker" value="<?php 	 echo date('d-m-Y', strtotime($rfq_createddate));?>" required>
						</div>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input name="subject" type="text" class="form-control" placeholder="Please enter Subject" value=" <?php echo $rfq_subject;?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
						<?php 
						$rfq_status = "";
					   $sql = "SELECT t1.Name FROM `c_codetable` t1 where t1.id = ".$rfq_statusid;
						$result = $conn->query($sql);
						if (isset($result)){
							if ($result->num_rows > 0) {
								// output data of each row
								while($row = $result->fetch_assoc()) {
									$rfq_status = $row["Name"];
									
								}
							}
						}


					   ?>
                        <input name="status" type="text" readonly class="form-control"
                               value="<?php echo $rfq_status; ?>">
                    </div>
                    <div class="form-group">
                        <label>Business Registration No.</label>
                        <input name="reg_no" type="text" readonly class="form-control"
                               value="<?php echo $reg_no; ?>">
                    </div>
                    <div class="form-group">
                        <label>Contact Person Last Name</label>
                        <input name="last_name" type="text"  class="form-control" value="<?php echo $LName; ?>" placeholder="Last Name" >
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                      					
						<div class="input-group date col-sm-5">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" name="due_date" class="form-control pull-right" id="due_datepicker" value="<?php echo date('d-m-Y', strtotime($FinalClosingDate)); ?>	">
						</div>
                    </div>
                    <div class="form-group">
                        <label>Preferred Payment Terms</label>
                        <select name="payment_terms" type="text" class="form-control" >
                            <option <?php  if($PreferredPaymentTerms=="7 days"){echo "selected";} ?>	>7 days</option>
                            <option <?php  if($PreferredPaymentTerms=="30 days"){echo "selected";} ?>?>>30 days</option>
                            <option <?php  if($PreferredPaymentTerms=="45 days"){echo "selected";} ?> ?>>45 days</option>
                            <option <?php  if($PreferredPaymentTerms=="60 days"){echo "selected";} ?> ?>>60 days</option>
                            <option <?php  if($PreferredPaymentTerms=="90 days"){echo "selected";} ?> ?>>90 days</option>
                            <option <?php  if($PreferredPaymentTerms=="120 days"){echo "selected";} ?> ?>>120 days</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">File Attachments</h3>

            
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
					<input id="rfq_upload" type="file" name="rfq_upload" />
					<br>
                    <button type="button" id="addfilelist" class="btn btn-sm btn-info" value="+ Attach file">
                        + Add File Attachment
                    </button>
					
                </div>
            </div>
			<br>
			<div class="row">
                <div class="col-sm-6">
				  <table class="table table-hover" id="fileList">
					<!-- The file list will be shown here -->
					<tbody>
					<?php 
						$count = 0;
						$query = "SELECT t2.FileName FROM t_document t1 Inner Join t_fileattachments t2 on t2.T_Document_Id = t1.Id Where t1.Status = 1 and t2.Status = 1 and C_DocumentType = 6 and t1.Id = ". $rfq_id;
						$results = $db->pdoQuery($query)->results();
						if (!empty($results)){
							
							foreach ($results as $row) {
								$count = $count+1;
								?>
								<tr id="tr_<?php echo $count;?>" align="left">
									
									
									<td><?php
						$out = '<a href="attachment/' . $row["FileName"] .'" target="_blank">'.$row["FileName"].'</a><input type="hidden" name="attachment[]" value="' . $row["FileName"] .'" >';
						echo $out;
						?></td>
						<td><button type="button" OnClick="RemoveFile(this);" class="btn btn-sm btn-del" value="tr_<?php echo $count;?>">Remove </button> <br></td>
								</tr>
								 
								<?php
							}
						}
						?>
					</tbody>
				  </table>
				  <input type="hidden" id="fileno" value="<?php echo $count;?>">
			</div>
               
            </div>
        </div>
    </div>
   
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Search Services</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Service Category 1</label>
                        <select id="servicecategory1" class="form-control" size="10">
                            
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Service Category 2</label>
                         <select id="servicecategory2" class="form-control" size="10">
                            
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Material</label>
                        <select id="services" class="form-control" size="10">
                            
                        </select>
                    </div>
                </div>
                <div class="col-sm-1">

                    <div class="form-group">
                        <label>Thickness</label>
                        <input type="text" id="default_thickness_value">
						<input type="hidden" id="default_thickness_uom">
                    </div>
                    <div class="form-group">
                        <label>Length</label>
                        <input type="text" id="default_length_value">
						<input type="hidden" id="default_length_uom">
                    </div>
                    <div class="form-group">
                        <label>Width</label>
                        <input type="text" id="default_width_value">
						<input type="hidden" id="default_width_uom">
                    </div>
					<input type="hidden" id="metal_type">
                    
					 <button type="button" id="add_service" class="btn btn-sm btn-info" value="  + Add Service">
                          + Add Service
                    </button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Selected Services</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
				<input type="hidden" id="serviceno" value="0">
                    <table class="table table-hover" id="servicelist">
					<thead>
                        <tr>
                            <th><input type="hidden"></th>
                            <th>Cat 1</th>
                            <th>Cat 2</th>
                            <th>Cat 3</th>
                            <th width="10%">Metal Type</th>
                            <th>Supplier Provide Materials</th>
                            <th>Supplier Provide Transport</th>
							<th></th>
                        </tr>
						</thead>
						<tbody>
                         <?php 
						$query = "SELECT t1.Id, t1.Supplier_Provide_Material, t1.Supplier_Provide_Transport, t1.`M_Service_Id`, t3.ServiceName, t3.C_Metal_Type, t3.M_Parent_Services_Id FROM `td_requiredservices` t1 INNER JOIN m_services t3 on t3.Id = t1.M_Service_Id Where `T_RFQ_Id` = ".$rfq_id;
						$results = $db->pdoQuery($query)->results();
						if (!empty($results)){
							$count = 0;
							foreach ($results as $row) {
								$count = $count+1;
								?>
								<tr id="trservice_<?php echo $count;?>" align="left" >
									<td><?php echo $count; ?></td>
									 <td><?php 
											 $query2 = "SELECT t3.ServiceName, t3.M_Parent_Services_Id FROM  m_services t3 Where `Id` = (SELECT M_Parent_Services_Id FROM  m_services  Where `Id` = ".$row["M_Parent_Services_Id"].") Limit 1";
											$results2 = $db->pdoQuery($query2)->results();
											if (!empty($results2)){
												foreach ($results2 as $row2) {
													echo  $row2["ServiceName"];
												}
											}
									  ?></td>
									<td><?php 
									$query1 = "SELECT t3.ServiceName, t3.M_Parent_Services_Id FROM  m_services t3 Where `Id` = ".$row["M_Parent_Services_Id"]."  Limit 1";
									$results1 = $db->pdoQuery($query1)->results();
									if (!empty($results1)){
										foreach ($results1 as $row1) {
											echo  $row1["ServiceName"];
										}
									}
									?></td>
									<td><?php echo  $row["ServiceName"]; ?></td>
									<td ><?php	
											$query4 = "SELECT * FROM `c_codetable` WHERE `Id` = ".$row["C_Metal_Type"]."  Limit 1";
											$results4 = $db->pdoQuery($query4)->results();
											if (!empty($results4)){
												foreach ($results4 as $row4) {
													echo  $row4["Name"];
												}
											}
									
									echo  $row["C_Metal_Type"]; ?></td>
									<td><input type="checkbox" name="chk_material[]" <?php if($row["Supplier_Provide_Material"]== "1"){echo "checked";} ?>> </td>
									<td><input type="checkbox" name="chk_transport[]" <?php if($row["Supplier_Provide_Transport"]== "1"){echo "checked";} ?>> </td>
									<td>
									<?php 
									$query5 = "SELECT * FROM `td_requiredservicesparameters` WHERE `TD_RequiredServices_Id` = ".$row["Id"];
											$results5 = $db->pdoQuery($query5)->results();
											if (!empty($results5)){
												foreach ($results5 as $row5) {
													if($row5["ParameterName"] == "Thickness"){
														echo '<input type="hidden" id="thicknessvalue" name="thicknessvalue[]" value="'. $row5["ParameterValue"] .'"><input type="hidden" id="thicknessuom"  name="thicknessuom[]" value="'. $row5["Uom"] .'">';
													}
													elseif($row5["ParameterName"] == "Length"){
														echo '<input type="hidden" id="lengthvalue" name="lengthvalue[]" value="'. $row5["ParameterValue"] .'"><input type="hidden" id="lengthuom"  name="lengthuom[]" value="'. $row5["Uom"] .'">';
													}
													elseif($row5["ParameterName"] == "Width"){
														echo '<input type="hidden" id="widthvalue" name="widthvalue[]" value="'. $row5["ParameterValue"] .'"><input type="hidden" id="widthuom"  name="widthuom[]" value="'. $row5["Uom"] .'">';
													}
												}
											}
									?>			<button type="button" OnClick="RemoveService(this);" class="btn btn-sm btn-del" value="trservice_<?php echo $count;?>">Remove </button></td>
												</tr>
												<?php
											}
										}
									?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12">
                    <h4>Parameters</h4>
                </div>
                <div class="col-sm-12">
                    <table class="table table-hover">
                        <tr>
                            <th>Param</th>
                            <th>Value</th>
                            <th>UOM</th>
                        </tr>
                        <tr>
                            <td>
                                Thickness
                            </td>
                            <td>
                                <input type="text" id="show_thickness_value" name="show_thickness_value" readonly>
                            </td>
                            <td>
                                 <input type="text" id="show_thickness_uom" name="show_thickness_uom" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Length
                            </td>
                            <td>
                                 <input type="text" id="show_length_value" name="show_length_value" readonly>
                            </td>
                            <td>
                                <input type="text" id="show_length_uom" name="show_length_uom" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Width
                            </td>
                            <td>
                                 <input type="text" id="show_width_value" name="show_width_value" readonly>
                            </td>
                            <td>
                                 <input type="text" id="show_width_uom" name="show_width_uom" readonly>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
   

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Search Suppliers</h3>
					
            <div class="box-tools pull-right">
				<button type="button" id="btn_search_suppliers" class="btn btn-sm btn-search" value="Search Suppliers">
							<i class="fa fa-refresh"></i>
				</button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="#tab_searchsuppliers" data-toggle="tab" aria-expanded="false">Search Suppliers</a></li>
              <li class="active"><a href="#tab_selectedsuppliers" data-toggle="tab" aria-expanded="true">Selected Suppliers</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_searchsuppliers">
                <table class="table table-hover" id="search_suppliers">
				<thead>
				<tr>
                    <th>&nbsp;</th>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
				</thead>
                <tbody>
                

                    
               

                </tbody>
            </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="tab_selectedsuppliers">
                <table class="table table-hover"  id="selected_suppliers">
				<thead>
				<tr>
                    <th>&nbsp;</th>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
                
				</thead>
                <tbody>
				<?php 
						$count = 0;
						$query = "SELECT M_User_Id FROM t_targetedsuppliers  Where T_Document_Id = ". $rfq_id;
						$results = $db->pdoQuery($query)->results();
						if (!empty($results)){
							
							foreach ($results as $row) {
								$count = $count+1;
								
								?>
								 <tr id='trsupplier_<?php echo $row["M_User_Id"]; ?>'>
                            <td>
                                <img class='profile-user-img img-responsive img-circle'
                                     src='img/user".$row["Id"]."-160x160.jpg'
                                     alt='Supplier profile picture'>
									 <input type='hidden' name='search_supplier_id[]' value='<?php echo $row["M_User_Id"]; ?>' >
									  <input type='hidden' name='selected_supplier_id[]' value='<?php echo $row["M_User_Id"]; ?>' >
                            </td>
                            <td>".$row["UserName"]."</td>
                            <td>Company Address</td>
                            <td><span class='label label-success'>Approved</span></td>
                            <td>
                               <button type='button' value='<?php echo $row["M_User_Id"]; ?>' class='btn btn-sm btn-info' Onclick='ViewProfile(this);'>              View Profile       </button>	
                                <hr>
                                <button type='button' value='trsupplier_<?php echo $row["M_User_Id"]; ?>' class='btn btn-sm btn-info' Onclick='AddtoRequestList(this);'>                Add to Request List       </button>	
                            </td>
                        </tr>  
								 
								<?php
							}
						}
						?>
                                

                </tbody>
            </table>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
					
            
        </div>
    </div>
    
</form>
    <?php 
	}else{
			?>
			<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">This is invalid ID</h3>
	<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
				
			</div>
			</div>
			
			<?php
		}
	}?>
	<script>
	$(function () {
		//Date picker
    $('#rfq_datepicker').datepicker({
      
	   format: "dd-mm-yyyy",
	   autoclose: true,
    todayHighlight: true,
	todayBtn: "linked",
    })
	$('#due_datepicker').datepicker({
      
	   format: "dd-mm-yyyy",
	   autoclose: true,
    todayHighlight: true
    });
	});
	
	 
		
	  $('button[id=addfilelist]').click(function(){
		var fileno = $("input[id=fileno]").val();
		var file_data = $('#rfq_upload').prop('files')[0];   
		var form_data = new FormData();                  
		form_data.append('file', file_data);   
		$.ajax({
					url: 'upload.php', // point to server-side PHP script 
					dataType: 'text',  // what to expect back from the PHP script, if anything
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					  dataType: 'json',
					success: function(data){
						fileno = parseInt(fileno)+1;
						 $("#fileList tbody").append('<tr id="tr_'+fileno+'" align="left"><td><input type="hidden" name="attachment[]" value="'+data.message+'" ><a href="attachment/'+data.message+'" target="_blank">'+data.message+'</a> </td><td><button type="button" OnClick="RemoveFile(this);" class="btn btn-sm btn-del" value="tr_'+fileno+'">Remove </button> <br></td></tr>');
						$("input[id=fileno]").val(fileno);
						$('#rfq_upload').val("");
					}
		 });
	 
		
		 
		
		  
		  
	  });
	  
	  function RemoveFile(objButton){  
		var trid = objButton.value;
		row = $('#' + trid);
		row.remove();
		}
	
	
	$(document).ready(function () {
		
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
			 
            if (this.readyState == 4 && this.status == 200) {
				$("#servicecategory1").find('option').remove().end();
				$("#servicecategory1").append(this.responseText);
               
            }
        };
        xmlhttp.open("GET","market.php?function=servicecategory1",true);
        xmlhttp.send();
	});
	 
	 $('select[id=servicecategory1]').change(function(e){
		 var id = $('select[id=servicecategory1]').val();
           if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				$("#servicecategory2").find('option').remove().end();
				$("#servicecategory2").append(this.responseText);
               
            }
        };
        xmlhttp.open("GET","market.php?servicecategory1id="+id+"&function=servicecategory2",true);
        xmlhttp.send();
        });
		
		$('select[id=servicecategory2]').change(function(e){
		 var id = $('select[id=servicecategory2]').val();
           if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				$("#services").find('option').remove().end();
				$("#services").append(this.responseText);
               
            }
        };
        xmlhttp.open("GET","market.php?servicecategory1id="+id+"&function=servicecategory2",true);
        xmlhttp.send();
        });
		
		$('select[id=services]').change(function(e){
		 var id = $('select[id=services]').val();
           if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
       
		
		 xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var valueuom =  this.responseText;
				var array = valueuom.split(',');
				$("#default_thickness_value").val(array[0]);
               $("#default_thickness_uom").val(array[1]);
			   
			   $("#default_length_value").val(array[2]);
               $("#default_length_uom").val(array[3]);
			   
				$("#default_width_value").val(array[4]);
               $("#default_width_uom").val(array[5]);
			   $("#metal_type").val(array[6]);
            }
        };
        xmlhttp.open("GET","market.php?servicecategory1id="+id+"&function=services",true);
        xmlhttp.send();
        });
		
		
		$('button[id=add_service]').click(function(){
		   var servicecategory1id = $('select[id=servicecategory1]').val();
		   var servicecategory1value = $('select[id=servicecategory1] option:selected').text();
			var servicecategory2id = $('select[id=servicecategory2]').val();
		   var servicecategory2value = $('select[id=servicecategory2] option:selected').text();
			var serviceid = $('select[id=services]').val();
		   var servicevalue = $('select[id=services] option:selected').text();
		   var serviceno = $("input[id=serviceno]").val();
		   
		   if(servicevalue == ""){
			   alert("Select service!")
		  }else{
			 serviceno = parseInt(serviceno)+1;
			 $("input[id=serviceno]").val(serviceno);
			
			 $("#servicelist tbody").append('<tr id="trservice_'+serviceno+'" align="left" OnClick="ShowService(this);"><td><input type="hidden" name="chk[]" value="'+serviceno+'" > </td>	<td>'+servicecategory1value+'<input type="hidden" name="cat1[]" value="'+servicecategory1value+'" readonly></td>			 <td>'+servicecategory2value+'<input type="hidden" name="cat2[]" value="'+servicecategory2value+'" readonly></td>		<td>'+servicevalue+'<input type="hidden" name="serviceid[]" class="serviceid" value="'+serviceid+'" readonly><input type="hidden" name="service[]" value="'+servicevalue+'" readonly></td>			<td>'+ $("input[id=metal_type]").val() +'<input type="hidden" name="metaltype[]" value="'+ $("input[id=metal_type]").val() +'" readonly></td>		<td><input type="checkbox" name="chk_material[]"> </td> <td><input type="checkbox" name="chk_transport[]"> </td>	<td><button type="button" OnClick="RemoveService(this);" class="btn btn-sm btn-del" value="trservice_'+serviceno+'">Remove </button> <input type="hidden" id="thicknessvalue" name="thicknessvalue[]" value="'+ $("input[id=default_thickness_value]").val() +'"><input type="hidden" id="thicknessuom"  name="thicknessuom[]" value="'+ $("input[id=default_thickness_uom]").val() +'"><input type="hidden" id="lengthvalue" name="lengthvalue[]" value="'+ $("input[id=default_length_value]").val() +'"><input type="hidden" id="lengthuom" name="lengthuom[]" value="'+ $("input[id=default_length_uom]").val() +'"><input type="hidden" id="widthvalue" name="widthvalue[]" value="'+ $("input[id=default_width_value]").val() +'"><input type="hidden" id="widthuom" name="widthuom[]" value="'+ $("input[id=default_width_uom]").val() +'"><br></td></tr>'); 
		  } 
		 
	  });
	  
	   function RemoveService(objButton){  
			var trid = objButton.value;
			row = $('#' + trid);
			row.remove();
			$('#show_thickness_value').val("");
			$('#show_thickness_uom').val("");
			
			$('#show_length_value').val("");
			$('#show_length_uom').val("");
			
			$('#show_width_value').val("");
			$('#show_width_uom').val("");
		}
		
		function ShowService(objButton){  
			var trid = objButton.id;
			row = $('#' + trid);
			$('#show_thickness_value').val($('#' + trid +' #thicknessvalue').val());
			$('#show_thickness_uom').val($('#' + trid +' #thicknessuom').val());
			
			$('#show_length_value').val($('#' + trid +' #lengthvalue').val());
			$('#show_length_uom').val($('#' + trid +' #lengthuom').val());
			
			$('#show_width_value').val($('#' + trid +' #widthvalue').val());
			$('#show_width_uom').val($('#' + trid +' #widthuom').val());
			
		}
		
		$('button[id=btn_search_suppliers]').click(function(){
			var table = document.getElementById('servicelist');

			var rowLength = table.rows.length;
			var servicesid= "0";
			for(var i=1; i<rowLength; i+=1){
				var row = table.rows[i];
				var serviceid = row.getElementsByTagName("input")[3];
				
				servicesid = servicesid + "," +serviceid.value;
			}
			
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#search_suppliers tbody").find('tr').remove().end();
				    $("#search_suppliers tbody").append(this.responseText);
				}
			};
			xmlhttp.open("GET","market.php?servicesid="+servicesid+"&function=searchsupplierwithservicesid",true);
			xmlhttp.send();
		
		
	  });
	  
	  function AddtoRequestList(objButton){  
			var trid = objButton.value;
			row = $('#' + trid);
			 $("#selected_suppliers tbody").append(row);
			 objButton.innerHTML = "Remove from List";
			objButton.setAttribute( "onClick", "RemoveFromList(this);" );
			$('#' + trid + ' input[name="selected_supplier_id[]"]').val($('#' + trid + ' input[name="search_supplier_id[]"]').val());
		}
		
		function RemoveFromList(objButton){  
			var trid = objButton.value;
			row = $('#' + trid);
			 $("#search_suppliers tbody").append(row);
			 objButton.innerHTML = "Add to Request List";
			objButton.setAttribute( "onClick", "AddtoRequestList(this);" );
			$('#' + trid + ' input[name="selected_supplier_id[]"]').val("0");
		}
		
		$("#btnsave_rfq_top").click(function (e) {
		
			e.preventDefault();
			
				SaveRFQ();
			
		});
		
		$("#btnsubmit_rfq_top").click(function (e) {
		
			e.preventDefault();
			
				SubmitRFQ();
			
		});
	   
	function SaveRFQ() {
        
            $.ajax({

                url: 'market.php?function=editrfq&act=draft',
                type: 'GET',
                data: $("#edit_rfq").serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    $("#edit_rfq").remove();
                    $btn.button("reset");
                },
                error: function (data) {
                    $("#notify .message").html("<strong>100000" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    $btn.button("reset");
                }

            });

    }
	
	function SubmitRFQ() {
        
            $.ajax({

                url: 'market.php?function=editrfq&act=submit',
                type: 'GET',
                data: $("#edit_rfq").serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    $("#edit_rfq").remove();
                    $btn.button("reset");
                },
                error: function (data) {
                    $("#notify .message").html("<strong>100000" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    $btn.button("reset");
                }

            });

    }
	</script>