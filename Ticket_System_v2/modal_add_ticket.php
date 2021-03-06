<!--
    Author: Bailey Whitehill
    Description: This code is the "Add Ticket" popup window. Submitting this runs action_add_ticket.php
-->
<?php

        include("../MySQL_Connections/config.php");
         

    //Find all the ticket info given the ticketid
    $sqlGetTicketTypes = "SELECT * FROM `tickettypes`";
    $resultTicketTypes = $conn->query($sqlGetTicketTypes);
?>
<!-- Modal Window -->
<div id="myModal" class="modal" style="display:none;">

    <!-- Modal Content Box-->
    <div class="modal-content">
        
        <!-- Close Button that closes the Modal (Clicking outside popup also closes window)-->
        <span id="closeModal" class="close" onClick="closeTicket('myModal');">&times;</span>
        
        <!-- Popup Header -->
        <h3 class="modal-title">Add New Maintenance Ticket</h3>
        
        
        <div class="modal-body">
            
            <form action="../Ticket_System_v2/action_add_ticket.php" method="post" class="form-horizontal" role="form"  enctype="multipart/form-data">
                
                <!--Use a default user id for all employee-created tickets and add a note with the name of the author-->
                <input type="hidden" name="intUserId" value="999">
                <input type="hidden" name="currentPage" value="<?php echo basename($_SERVER['SCRIPT_FILENAME']);?>">
                <input type="hidden" name="dtSubmitted" value="<?php echo date("Y-m-d")?>">
                <input type="hidden" name="strTime" value="<?php echo date("H:i:s")?>">
                <input type="hidden" name="strEmployeeUsername" value="<?php echo $_COOKIE['user']?>">
                
                <!---the ticket will be displayed at a initial gps point (such as their admin building) until the gps marker is moved--->
                <input type="hidden" name="gpsLat" id="gpsLat" value="41.115618">
                <input type="hidden" name="gpsLong" id="gpsLong" value="-85.111250">
    
    
                <div class="modal_view">
                    <span>
                        
                        <!--Ticket Title-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="strTitle" class="col-sm-2 control-label">Title</label>
                                <input type="text" id="strTitle" name="strTitle" class="form-control" />
                                
                            </div>
                        </div>
                        
                        <!--Ticket Description-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="strDescription" class="col-sm-2 control-label">Ticket Description</label>
                                <textarea name="strDescription" id="strDescription" class="form-control" ></textarea>
                                
                            </div>
                        </div>
                        
                        <!--Upload an Image-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="strImageFilePath" class="col-sm-2 control-label">Upload Image</label>
                                <input type="file" name="strImageFilePath" id="strImageFilePath" class="form-control" onChange="checkImageSize();">
                                <div id="ShowError"><span>Image is too big!</span></div>
                            </div>
                        </div>
                        
                        <!--Ticket Type-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="intTypeId" class="col-sm-2 control-label">Type</label>
                                <select id="intTypeId" name="intTypeId"  class="form-control" >
                                     <?php while($row = $resultTicketTypes->fetch_array(MYSQLI_ASSOC)){ ?>
                                        <option value="<?php echo $row['intTypeId']?>"><?php echo $row['strTicketType']?></option>
                                    <?php }?>
                                </select>
                                
                            </div>
                        </div>
                        
                        <!--Urgent Flag-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="bitUrgent" class="col-sm-2 control-label">Urgent</label>
                                <input type="checkbox" name="bitUrgent" class="urgentCheck" >
                                
                            </div>
                         </div> 
                         
                         <!--Submit Button-->
                         <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                        
                    </span>
                
                    <!--Google Map to mark the ticket location-->
                    <span class="Modal_add_Map">
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                
                                <label for="mapCanvas" class="col-sm-2 control-label">Drag the Marker to Set the Problem Location</label>
                                <div id="mapCanvas" class="mapCanvas"></div>
                      
                           </div>
                        </div>
                        
                    </span>
                   
               </div>
               
               <br style="clear:both"/>
               
            </form>
        </div>
    </div>
</div>
        
<!--Javascript to handle the modal display & image size -->
<script>

    
    //check the image size to make sure it's not larger than the allowed size
    function checkImageSize(){
        var uploadField = document.getElementById("strImageFilePath");

        uploadField.onchange = function() {
            if(this.files[0].size > 4194304){
                document.getElementById("ShowError").display="block";
               this.value = "";
            };
        };
    }
</script>
    