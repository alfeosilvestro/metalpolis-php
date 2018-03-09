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
    <h3 class="box-title">Search by service</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="form-group">
      <h3>Please select services ...</h3>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div id="messageforsupplier"></div>
            <div id="treeview-checkbox-demo">
              <ul>
                <?php
                $sql = "SELECT * FROM `m_services` where Status = 1 and M_Parent_Services_Id is null  ";
                $result = $conn->query($sql);
                if (isset($result)){
                  if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                      echo "<li data-value='". $row["Id"] ."'>" . $row["ServiceName"] ;
                      $servicecategory1id = $row["Id"];
                      $sql1 = "SELECT * FROM `m_services` where Status = 1 and  M_Parent_Services_Id = ".$servicecategory1id ;
                      $result1 = $conn->query($sql1);
                      if (isset($result1)){
                        if ($result1->num_rows > 0) {
                          echo "<ul>";
                          // output data of each row
                          while($row1 = $result1->fetch_assoc()) {
                            echo "<li data-value='". $row1["Id"] ."'>" . $row1["ServiceName"] ;
                            $servicecategory1id1 = $row1["Id"];
                            $sql2 = "SELECT * FROM `m_services` where Status = 1 and  M_Parent_Services_Id = ".$servicecategory1id1 ;
                            $result2 = $conn->query($sql2);
                            if (isset($result2)){
                              if ($result2->num_rows > 0) {
                                echo "<ul>";
                                // output data of each row
                                while($row2 = $result2->fetch_assoc()) {
                                  echo "<li data-value='". $row2["Id"] ."'>" . $row2["ServiceName"] ;
                                  $servicecategory1id2 = $row2["Id"];
                                  $sql3 = "SELECT * FROM `m_services` where Status = 1 and  M_Parent_Services_Id = ".$servicecategory1id2 ;
                                  $result3 = $conn->query($sql3);
                                  if (isset($result3)){
                                    if ($result3->num_rows > 0) {
                                      echo "<ul>";
                                      // output data of each row
                                      while($row3 = $result3->fetch_assoc()) {
                                        echo "<li data-value='". $row3["Id"] ."'>" . $row3["ServiceName"] ;
                                        $servicecategory1id3 = $row3["Id"];
                                        $sql4 = "SELECT * FROM `m_services` where Status = 1 and  M_Parent_Services_Id = ".$servicecategory1id3 ;
                                        $result4 = $conn->query($sql4);
                                        if (isset($result4)){
                                          if ($result4->num_rows > 0) {
                                            echo "<ul>";
                                            // output data of each row
                                            while($row4 = $result4->fetch_assoc()) {
                                              echo "<li data-value='". $row4["Id"] ."'>" . $row4["ServiceName"] ;

                                              echo "</li>";
                                            }
                                            echo "</ul>";
                                          }

                                        }
                                        echo "</li>";
                                      }
                                      echo "</ul>";
                                    }

                                  }
                                  echo "</li>";
                                }
                                echo "</ul>";
                              }

                            }
                            echo "</li>";
                          }
                          echo "</ul>";
                        }

                      }
                      echo "</li>";
                    }
                  }
                }
                ?>

              </ul>
            </div>


            <input type="hidden" id="values" name="supported_service" value="">
          </div>
        </div>
      </div>

      <script src="dev/jquery.min.js"></script>
      <script src="dev/bootstrap.min.js"></script>
      <script src="dev/logger.js"></script>
      <script src="dev/treeview.js"></script>

      <script>
      $('#treeview-checkbox-demo').treeview({
        debug : true,
        data : ['links', 'Do WHile loop']
      });
      </script>
      <button type="button" id="btnsearch" class="btn btn-info">Search</button>

    </div>
    <div class="form-group">
      <table id="supplier_list" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>Company Name</th>
            <th>Registration No.</th>
            <th>Address</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>


<script>
$(function () {

  $("#btnsearch").click(function (e) {
    $('#values').val(
      $('#treeview-checkbox-demo').treeview('selectedValues')
    );


    var id = $('#values').val();
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        $("#supplier_list tbody").append(this.responseText);
      }
    };
    xmlhttp.open("GET","system/searchsuppliersbyservices.php?selectedValues="+id,true);
    xmlhttp.send();

    e.preventDefault();
  });
});
$("[id*=treeview-checkbox-demo] input[type=checkbox]").bind("click", function () {
  //Is Parent CheckBox
  var isChecked = $(this).is(":checked");
  $(this).parent().find("input[type=checkbox]").each(function () {
    if (isChecked) {
      $(this).prop( "checked", true );
    } else {
      $(this).removeAttr("checked");
    }
  });
});
</script>
