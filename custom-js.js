/**
 * Created by HP on 8/31/2017.
 */
var slideCount =1;
var ps_note_clicked=false;
var mg_mc_apmt_mouse_over=false;
//var ds=new DragSelect({
    //callback: function(elements) {
                //peoviderScheduleCallback(elements);
           // }
//});
function slideCalendarLeft() {       
            $('#mi_calendar_header,#mi_calender_body').animate({
                'marginLeft' : "-=160px" //moves left
            });   
            slideCount++;        
}
function slideCalendarRight() {  
        if(slideCount != 1) {
            $('#mi_calendar_header,#mi_calender_body').animate({
                'marginLeft' : "+=160px" //moves left
            });     
            slideCount--;
        }
}
function openSelectPatient(x) {
    console.log("called selectPatient");
    var appointment_time_id = x;
    $(".mi-gray-background-1").removeClass('mi-hide');
    $("#mi-patient-model").removeClass('mi-hide');
    $("#selected_appointment_time").val(appointment_time_id);
}
function openAppointmentDetails(apmt_id) {
    //load patient appointment comtent
    console.log("open appointment for :"+apmt_id);
    $.post("views/mc-appointment-details-body.php",
        {apmt_id: apmt_id} ,
        function (responseText) {
            $("#ng-mc-pc-apmt-div-appointment").html(responseText);
            $('#ngc-mc-appmt-appmt-id').val(apmt_id);
            //Notes
            loadAppointmentNote(apmt_id);
            loadApmtProcedures(apmt_id);
            loadApmtPayments(apmt_id);
        }
    );
    $("#mi-appointment-model").removeClass('mi-hide');    
    
}
function openMiModel(x,y) {
    $(".mi-gray-background-"+x).removeClass('mi-hide');
    $("#"+y).removeClass('mi-hide');
}
function closeMiModel(x,y) {
    $("#"+y).addClass('mi-hide');
    $(".mi-gray-background-"+x).addClass('mi-hide');
}

function setAppointment(x) {
    console.log("called setAppointment:"+x);
    var appointment_time_id = x;
    console.log(appointment_time_id);
    $("#"+ appointment_time_id).append("<div class='mi-set-appointment' style='height: 40px;'>Jon Snow</div>");
    $("#mi-appointment-model").addClass('mi-hide');
    $(".mi-gray-background-1").addClass('mi-hide');
}
function openAppointment(app_id){
    console.log("called openAppointment:"+app_id);
    openAppointmentDetails(app_id);
    return;
}
function loadAppointment(app_id) {
    console.log("called loadAppointment:"+app_id);
    var url="models/ajx/ajxc_mc_appointment_get_data.php?id="+app_id;
    console.log(url);
        $.getJSON(url, function(json){
            addAppointment(json[0].id,json[0].time_slot_s_id,json[0].patient_name,json[0].no_of_slots,json[0].status_img,json[0].status_img,json[0].note,json[0].status,json[0].info_txt);
        });
}
function loadAllAppointments(unit,user,date,run_callback,x){
    console.log("called loadAll Appointment:"+unit+" Callback:"+run_callback);
    var url="models/ajx/ajxc_mc_appointment_get_data.php?unit_id="+unit+"&doctor_id="+user+"&date="+date;
    console.log(url);
        $.getJSON(url, function(json){
            $.each(json, function (index, value) {
                if(json.length>0){
                    addAppointment(value.id,value.time_slot_s_id,value.patient_name,value.no_of_slots,value.status_img,value.status_alt,value.note,value.status,value.info_txt);

                }
            })
            if(run_callback){
                console.log("running callback");
                setSelectables(x,unit);
            }
            else{
                console.log("NOT running callback,");
            }
        });
}
var apmt_start_h=0;
function addAppointment(id,slot_id,name,n,status_img,status_alt,note,status,info_txt){
    if(note==null){
        note='';
    }
    var max_char=parseInt(n-1)*13;
    if(note.length>max_char){
        note_n=note.substr(0, max_char);
    }
    else{
        note_n=note;
    }
    var pop_html=info_txt;
    var status_cls='ng_mc_apmt_'+status;
    var h=20*parseInt(n);
    $("#"+ slot_id).append("<div id='ng_mc_apmt_"+id+"' class='ng_mc_appointment "+status_cls+"' style='height: "+h+"px;'><span>"+name+"</span>\n\
        <span>"+note_n+"<div class='ng_mc_apmt_info' style='line-height:14px;'>"+pop_html+"</div></span><span id='ng_mc_apmt_span_"+id+"' style='position: absolute;bottom: 0px;right: 0px;'><img src='images/"+status_img+"' height='16px' title='"+status_alt+"'></span></div>");
    $("#ng_mc_apmt_"+id).mouseover(function() {
        console.log('mouse enetred');
        $(this).find("div.ng_mc_apmt_info").show();
        mg_mc_apmt_mouse_over=true;
    }).mouseout(function() {
        console.log('mouse left');
        $("div.ng_mc_apmt_info").hide();
        mg_mc_apmt_mouse_over=false;
    });
    $("#ng_mc_apmt_"+id).click(function(){
        if($(this).data('dragging')) return;
        openAppointment(id);
    });
    $("."+status_cls).draggable({
        containment: '#mi_calender_body',
        revert: "invalid",
        start: function(event, ui){
            $(this).data('dragging', true);
        },
        stop: function(event, ui){
            setTimeout(function(){
                console.log("hi " + this);
                $(event.target).data('dragging', false);
            }, 1);
        }
    });
    $("."+status_cls).resizable({
      grid: 24,
      handles: 's',
      start: function( event, ui ) {
          console.log($(this).height());
          apmt_start_h=$(this).height();
          $(this).data('dragging', true);
      },
      stop: function( event, ui ) {
          console.log($(this).height());
          resizeAppointment($(this).attr('id'),apmt_start_h,$(this).height());
          setTimeout(function(){
                console.log("hi " + this);
                $(event.target).data('dragging', false);
            }, 1);
      }
    });
    $("#ng_mc_apmt_span_"+id).click(function(event){
        event.stopPropagation();
        openStatusChange(id);
    });
}
function removeAppointment(id){
    $('#ng_mc_apmt_'+id).remove();
}
function fillAvailability(unit,user,date,run_callback,x){
    console.log("called fill schedule:"+unit+" user:"+user);
    var url="models/ajx/ajxc_mc_provider_schedule_data.php?sid=102&unit_id="+unit+"&date="+date+"&user_id="+user;
    console.log(url);
    $.getJSON(url, function(json){
        if(json[0]['result']=='1'){
            $.each(json[1], function (index,value) {
                console.log(index+"="+value);
                    if(value[1]=='F'){
                        $('#'+value[0]).addClass("ng-calender-avail");
                    }
                    else if(value[1]=='P'){
                        $('#'+value[0]).addClass("ng-calender-avail-past");
                    }
                    //
                    //$('#'+index).addClass("ng-calender-unavail");
            })
        }
        if(run_callback){
            console.log("running callback");
            //setSelectables(x,unit);
        }
        else{
            console.log("NOT running callback");
        }
    });
}
function loadFullRangeAvailability(unit,user,active_date,x){
    console.log(active_date);
    var d=new Date(active_date);
    var d_temp=new Date();
    for(var j=-3;j<9;j++){
        d_temp= new Date(d.getTime()+(j*86400000));
        var d_str=d_temp.getFullYear()+"-"+(d_temp.getMonth()+1)+"-"+d_temp.getDate();
        console.log(d_str);
        console.log("J="+j);
        fillAvailability(unit,user,d_str,false,x);
        
        if(j==8){
            //load with callback
            if(x==2){
                fillAvailability(unit,user,d_str,true,x);
            }
        }
        else{
            fillAvailability(unit,user,d_str,false,x);
        }
        
    }
    
}
function loadFullRangeAppointments(unit,user,center_date,x){
    console.log("loading appointmets for center date:"+center_date);
    var d=new Date(center_date);
    var d_temp=new Date();
    for(var j=-3;j<9;j++){
        d_temp= new Date(d.getTime()+(j*86400000));
        var d_str=d_temp.getFullYear()+"-"+(d_temp.getMonth()+1)+"-"+d_temp.getDate();
        console.log(d_str);
        console.log("J="+j);
        if(j==8){
            //load with callback            
            loadAllAppointments(unit,user,d_str,true,x);
        }
        else{
            loadAllAppointments(unit,user,d_str,false,x);
        }
    }
    
}
////////??????????????????????
function submitAppointmentAdd(x,action){
    console.log("submitting Appointment add");
    $('#ngc-mc-loading').removeClass("mi-hide");
    $.post($('#ng-mc-apmt-ptn-frm').attr('action'), $('#ng-mc-apmt-ptn-frm').serialize(), function(json) {
          console.log(json);
          $('#ngc-mc-loading').addClass("mi-hide");
          if(json[0]['result']=='1'){
             console.log("DONE");
             $('#ngc-mc-loading').addClass("mi-hide");
             loadAppointment(json[0]['app_id']);
            }
            else{
                alert("Error :"+json[1]['error']);
            }
        },'json'); 
    closeMiModel(2,'ngc-modle-dialog');
    closeMiModel(1,'mi-patient-model');
}
function completeAppointment(){
    if(action=='add-new'){
        $('#ng-mc-pc-apmt-loading').removeClass("mi-hide");
        $.post($('#ng-mc-pc-apmt-frm').attr('action'), $('#ng-mc-pc-apmt-frm').serialize(), function(json) {
              console.log(json);
              $('#ng-mc-pc-apmt-loading').addClass("mi-hide");
              if(json[0]['result']=='1'){
                 console.log("DONE");
                 loadAppointment(json[0]['app_id']);
                }
                else{
                    alert("Error :"+json[1]['error']);
                }
            },"json"); 
    }
    $("#mi-appointment-model").addClass('mi-hide');
    $(".mi-gray-background-1").addClass('mi-hide');
}
$("tbody tr").click(function () {
    //$('.mi-selected').removeClass('mi-selected');
    //$(this).addClass("mi-selected");
    // var rowId = $('.tt',this).html();
    // alert(rowId);
});
var ps_selected_date='';
function checkCalenderView(x,unit_id,user_id,center_date) {
    $('#ng-mc-home-active_view').val(x);
    console.log("Calader view CCW:"+x+"Unit:"+unit_id+"User:"+user_id+"Date:"+center_date);
    $.ajax({
        url: "models/select-date.php?date="+center_date+"&calenderView="+x+"&unit_id="+unit_id+"&user_id="+user_id, success: function (responseText) {
            $("#mi-calendar").html(responseText);
            //scrollToCurrentTime();  
            if(x==1){
                loadFullRangeAvailability(unit_id,user_id,center_date,x); 
                loadFullRangeAppointments(unit_id,user_id,center_date,x);
                loadAllNotes(unit_id,user_id,center_date);
            }
            else{
                loadFullRangeAvailability(unit_id,user_id,center_date,x);
                loadAllNotes(unit_id,user_id,center_date);
                //setSelectables(x,unit_id);
                //set onclick of date header
                $('.mi-calendar-date-block').click(function(){
                    console.log("date header Clicked");
                    if($(this).hasClass("selectable_col")){
                        var id=$(this).attr("id");
                        if(ps_selected_date!=''){
                            $( "."+ps_selected_date ).selectable( "destroy" );
                            $('#'+ps_selected_date).removeClass('ps_selected_col');
                            $("."+ps_selected_date+" .mi-calendar-sub-block-1").removeClass('ps_selected_col');
                            $("."+ps_selected_date+" .mi-calendar-sub-block-2").removeClass('ps_selected_col');
                        }
                        $('#ngc-mc-ps-selected-date').val(id);
                        console.log("Date ID="+id);
                        ps_selected_date=id;   
                        $('#'+id).addClass('ps_selected_col');
                        $("."+id+" .mi-calendar-sub-block-1").addClass('ps_selected_col');
                        $("."+id+" .mi-calendar-sub-block-2").addClass('ps_selected_col');
                        $( "."+id ).bind("mousedown", function(e) {
                            e.metaKey = true;
                            }).selectable({
                            filter: ".mi-calender-main-sub-block-1-inner-content",
                            stop: function( event, ui ) {
                                ps_selected_slots=new Array();
                                $('#ngs-ps-save').removeClass('ngs_span_but_disable').addClass('ngs_span_but_enable');
                                $(".mi-calendar-main-content-block").not(this).find('.mi-calender-main-sub-block-1-inner-content').removeClass('ui-selected');
                                console.log("STOP");
                                var elemets = new Array();
                                $( ".ui-selected", this ).each(function() {
                                    console.log($(this).attr("id"));
                                    ps_selected_slots.push($(this).attr("id"));
                                  });
                                  //peoviderScheduleCallback(elemets,unit);
                            }
                        });   
                    }
                    else{
                        console.log('old date');
                    }
                });
                $( "#mi_calender_body").selectable({
                    filter: ".mi-calender-main-sub-block-2-inner-content",
                    stop: function( event, ui ) {
                        console.log("STOP");
                        var elemets = new Array();
                        $( ".ui-selected", this ).each(function() {
                            console.log($(this).attr("id"));
                            elemets.push($(this).attr("id"));
                          });
                          if(!ps_note_clicked){
                            openProviderScheduleNoteAdd(elemets);
                          }
                    }
                  });
            }            
        }
    });
}

var ps_selected_slots=new Array();
function setSelectables(x,unit){
    console.log("Settign Selectables for "+x);
    if(x==1){
        $( "#mi_calender_body" ).selectable({
            filter: ".ng-calender-avail",
            distance: 0,
            stop: function( event, ui ) {
                console.log("STOP");
                var elemets = new Array();
                $( ".ui-selected", this ).each(function() {
                    console.log($(this).attr("id"));
                    elemets.push($(this));
                  });
                  if(!mg_mc_apmt_mouse_over){
                    appointementBookSelectCallback(elemets,unit);
                  }
            }
          });
        console.log("set selectable");
        //set droppable
        $('.mi-calender-main-sub-block-2-inner-content').droppable({
            accept: ".ng_mc_apmt_CANCELLED",
            drop: function( event, ui ) {
              event.stopPropagation();
              event.preventDefault();
              draggedElement = $(ui.draggable);
              dropZone = $(event.target);
              $(dropZone).append(draggedElement);
              draggedElement.css('left','unset').css('top','unset;')
                console.log("Dropped:"+$(this).attr('id'));
              //update appointment details
              moveAppointment(draggedElement.attr('id'), $(this).attr('id'));
            }
        });
        //set droppable
        $('.ng-calender-avail').droppable({
            drop: function( event, ui ) {
              event.stopPropagation();
              event.preventDefault();
              draggedElement = $(ui.draggable);
              dropZone = $(event.target);
              $(dropZone).append(draggedElement);
              draggedElement.css('left','unset').css('top','unset;')
                console.log("Dropped:"+$(this).attr('id'));
              //update appointment details
              moveAppointment(draggedElement.attr('id'), $(this).attr('id'));
            }
        });
        console.log("set droppable");
    }
    else if(x==2){
        $( ".mi-calendar-main-content-block" ).bind("mousedown", function(e) {
            e.metaKey = true;
            }).selectable({
            filter: ".mi-calender-main-sub-block-1-inner-content",
            stop: function( event, ui ) {
                ps_selected_slots=new Array();
                $(".mi-calendar-main-content-block").not(this).find('.mi-calender-main-sub-block-1-inner-content').removeClass('ui-selected');
                console.log("STOP");
                $( ".ui-selected", this ).each(function() {
                    console.log($(this).attr("id"));
                    ps_selected_slots.push($(this).attr("id"));
                  });
                  console.log(ps_selected_slots);
                  //peoviderScheduleCallback(elemets,unit);
            }
          });
        console.log("set selectable");
    }
}
function peoviderScheduleCallback(elements,unit_id){    
    if(elements.length>0){
        $('#ngc-mc-loading').removeClass("mi-hide");
        console.log(elements[0].attr('id'));
        console.log(elements[elements.length-1].attr('id'));
        $.post("views/mc-providers-schedules-body.php",
            {unit_id: unit_id,start_ts: elements[0].attr('id'),end_ts: elements[elements.length-1].attr('id')} ,
            function (responseText) {
                $("#ngc-mc-provider-schedule-add-body").html(responseText);
                $('#ngc-mc-loading').addClass("mi-hide");
                openMiModel(2,'mi-providers-schedule');
                //var ary_ele=ds.getSelection();
                //console.log(ary_ele);
                //ds.stop();
            }
        );
    }
}
function appointementBookSelectCallback(elements,unit_id){    
    if(elements.length>0){
        $('#ngc-mc-loading').removeClass("mi-hide");
        console.log(elements[0].attr('id'));
        console.log(elements[elements.length-1].attr('id'));
        $('#ngc-mc-loading').addClass("mi-hide");
        $('#ngc-mc-appmt-ts-start').val(elements[0].attr('id'));
        $('#ngc-mc-appmt-ts-end').val(elements[elements.length-1].attr('id'));
        $('#ngc-mc-appmt-n').val(elements.length);
        openMiModel(1,'mi-patient-model');
    }
}
function changeImage(x) {
    $("#caman_image").remove();
    $("#cam-img-body").append("<img id='caman_image' src='images/"+x+"' style='width: 100%;'>");

    const switch_img = 'images/'+x;
    Caman('#caman_image', switch_img, function() {
        this.revert(false);
        this.render();
    });
}
function changeOptions() {
    var mc_brightness = parseInt($('#brightness').val());
    var mi_cntrst = parseInt($('#contrast').val());
    var mi_sharpen = parseInt($('#sharpe').val());
    var mi_gamma = parseInt($('#gamma').val());

    const switch_img = $('#caman_image').attr('src');
    Caman('#caman_image', switch_img, function() {
        this.revert(false);
        this.brightness(mc_brightness).contrast(mi_cntrst).sharpen(mi_sharpen).gamma(mi_gamma).render();
    });
}
function updateTextInput(y,val) {
    $(".FilterValue-"+y).text(val);
}
function saveImage() {
    const switch_img = $('#caman_image').attr('src');
    Caman('#caman_image', switch_img, function() {
        this.render(function() {
            //this.save('png');
            var image = this.toBase64();
            $.ajax({
                    url: "models/save-image.php",
                    type: "POST",
                    data: {image1:image},
                    success: function (responseText) {
                }
            });
            var a = $("<a>").attr("href", "http://localhost/medical_software/contents/Image.jpg").attr("download", "Image.png").appendTo("body");
            a[0].click();
            a.remove();

            //this.toBase64();
            //var image1 = this.toBase64();
            //console.log(image1);
            //alert(image1);
            // $.ajax({
            //         url: "models/save-image.php",
            //         type: "POST",
            //         data: {image1:image1},
            //         success: function (responseText) {
            //         //$("#mi-calendar").html(responseText);
            //     }
            // });
        });
    });
}

function selectCurrentImage(x) {
    $('.mi-xray-image').removeClass('mi-selected-image');
    $("#"+x).addClass("mi-selected-image");
}
function deleteSelectedImage(){
    $(".mi-selected-image").remove();
}

function openAppointmentAddModel(ptn_id,ts_s,ts_e,n){
    $.post("views/mc-appointment-add-body.php?",
        {unit_id: $('#ng-mc-home-unit_id').val(),user_id: $('#ng-mc-home-user_id').val(),doctor_id:$('#ng-mc-home-active_doctor').val(),ptn_id: ptn_id,start_ts: ts_s,end_ts: ts_e, n:n} ,
        function (responseText) {
            $("#ngc-modle-dialog-content").html(responseText);
            $('#ngc-mc-loading').addClass("mi-hide");
            $('#ngc-modle-dialog-header').html('Add appointment');
            openMiModel(2,'ngc-modle-dialog');
        }
    ); 
}

//pharmacy functions start

function open_ph_Prescription() {
    $(".mi-gray-background").removeClass('mi-hide');
    $("#mi-ph-prescription").removeClass('mi-hide');
}
function close_ph_Prescription() {
    $("#mi-ph-prescription").addClass('mi-hide');
    $(".mi-gray-background").addClass('mi-hide');
}


//pharmacy functions end

function showButton(){
    $('#ngc-mc-calender-but-schedule').removeClass('mi-hide');
}
function hideButton(){
    $('#ngc-mc-calender-but-schedule').addClass('mi-hide');
}
function loadAppointmentNote(id){
    console.log("loading notes..");
    $.post("views/mc-appointment-details-body-notes.php",
        {apmt_id: id} ,
        function (responseText) {
            $("#ngc-mc-appmt-div-note").html(responseText); 
            $("#ngc-mc-tbl-apmt-note tr").click(function () {
                var id=$(this).closest('tr').attr('id');
                if($('#ngc-mc-appmt-selected-note-id').val()==id){
                    //Deselect
                    console.log($('#ngc-mc-appmt-selected-note-id').val()+"-"+id);
                    $('#ngc-mc-appmt-selected-note-id').val('');
                    $(this).removeClass('mi-selected');
                }
                else{
                    $('#ngc-mc-appmt-selected-note-id').val(id);
                    $("#ngc-mc-tbl-apmt-note tr").removeClass('mi-selected');
                    $(this).addClass('mi-selected');
                }
            });
        }
    );            
}
function loadAllNotes(unit_id,user_id,center_date,x){
    var d=new Date(center_date);
    var d_temp=new Date();
    d_temp= new Date(d.getTime()-(86400000*5));
    var from=d_temp.getFullYear()+"-"+(d_temp.getMonth()+1)+"-"+d_temp.getDate();
    d_temp= new Date(d.getTime()+(86400000*5));
    var to=d_temp.getFullYear()+"-"+(d_temp.getMonth()+1)+"-"+d_temp.getDate();
    
    console.log("loading notes");
    var url="models/ajx/ajxc_mc_provider_schedule_note.php?option=get-all&unit_id="+unit_id+"&doctor_id="+user_id+"&from_date="+from+"&to_date="+to;
    //console.log(url);
    $.getJSON(url, function(json){
        //console.log(json);
        if(json[0]['result']=='1'){
            $.each(json[1]['notes'], function (index,value) {
                //console.log(index+"="+value);
                    addNote(value[0],value[1], value[3],value[2]);
            })
        }
        else{
            console.log("No Notes");
        }
    });
    
}
function addNote(id,slot_id,note,n){
    console.log(n+slot_id+"id="+id);
    var max_char=parseInt(n)*13;
    if(note.length>max_char){
        note_n=note.substr(0, max_char);
    }
    else{
        note_n=note;
    }
    var h=parseInt(n)*20;
    //console.log(h);
    $("#"+ slot_id).append("<div id='ps_note_"+id+"' class='ng_ps_note' style='height: "+h+"px;z-index:90;'><span class='ng_mc_overlay_box'>"+note_n+"<div class='ng_mc_tooltip' style='line-height:14px;'>"+note+"</div></span></div>");
    $("#ps_note_"+id).mouseover(function() {
        console.log('Tool tip eneter');
        $(this).find("div.ng_mc_tooltip").show();
        ps_note_clicked=true;
    }).mouseout(function() {
        $("div.ng_mc_tooltip").hide();
        ps_note_clicked=false;
    });
    $("#ps_note_"+id).click(function(e){        
        e.stopImmediatePropagation();
        openProviderScheduleNoteEdit(id);
    });  
}
function removeNote(id){
    $("#ps_note_"+id).remove();
}
function loadDLPPrcedureResult(){
    $('#ngc-mc-loading').removeClass("mi-hide");
    $.post("views/mc-dlp-management-p-result.php",
        {unit_id: $('#ng-mc-home-unit_id').val()} ,
        function (responseText) {
            $("#ngc-mc-dlp-management-div-p-result").html(responseText);
            $('#ngc-mc-loading').addClass("mi-hide");
        }
    );
}
function openDLPProcedureAddModel(){
    $.post("views/mc-dlp-procedure_add.php?",
        {unit_id: $('#ng-mc-home-unit_id').val(),user_id: $('#ng-mc-home-user_id').val()} ,
        function (responseText) {
            $("#ngc-modle-dialog-content").html(responseText);
            $('#ngc-mc-loading').addClass("mi-hide");
            $('#ngc-modle-dialog-header').html('Add Procedure');
            openMiModel(2,'ngc-modle-dialog');
        }
    ); 
}
function openDLPProcedureEditModel(id){
    $.post("views/mc-dlp-procedure_edit.php?",
        {proc_id: id,user_id: $('#ng-mc-home-user_id').val()} ,
        function (responseText) {
            $("#ngc-modle-dialog-content").html(responseText);
            $('#ngc-mc-loading').addClass("mi-hide");
            $('#ngc-modle-dialog-header').html('Edit Procedure');
            openMiModel(2,'ngc-modle-dialog');
        }
    );
}
function loadApmtProcedures(apmt_id){
    console.log("loading procedure");
    $.post("views/mc-appointment-details-body-procedure.php",
        {apmt_id: apmt_id} ,
        function (responseText) {
            $("#ngc-mc-appmt-div-procedure").html(responseText); 
            $("#ngc-mc-tbl-apmt-procedure tr").click(function () {
                var id=$(this).closest('tr').attr('id');
                if($('#ngc-mc-appmt-selected-app-procedure-id').val()==id){
                    //Deselect
                    console.log($('#ngc-mc-appmt-selected-app-procedure-id').val()+"-"+id);
                    $('#ngc-mc-appmt-selected-app-procedure-id').val('');
                    $(this).removeClass('mi-selected');
                }
                else{
                    $('#ngc-mc-appmt-selected-app-procedure-id').val(id);
                    $("#ngc-mc-tbl-apmt-procedure tr").removeClass('mi-selected');
                    $(this).addClass('mi-selected');
                }
            });
        }
    );
            
}
function loadApmtPayments(apmt_id){
    console.log("loading payments");
    $.post("views/mc-appointment-details-body-payments.php",
        {apmt_id: apmt_id} ,
        function (responseText) {
            $("#ngc-mc-appmt-div-payments").html(responseText); 
            $("#ngc-mc-tbl-apmt-payments tr").click(function () {
                var id=$(this).closest('tr').attr('id');
                if($('#ngc-mc-appmt-selected-payment-id').val()==id){
                    //Deselect
                    console.log($('#ngc-mc-appmt-selected-payment-id').val()+"-"+id);
                    $('#ngc-mc-appmt-selected-payment-id').val('');
                    $(this).removeClass('mi-selected');
                }
                else{
                    $('#ngc-mc-appmt-selected-payment-id').val(id);
                    $("#ngc-mc-tbl-apmt-payments tr").removeClass('mi-selected');
                    $(this).addClass('mi-selected');
                }
            });
        }
    );
            
}

function loadApmtNotes(apmt_id){
    console.log("loading notes");
    $.post("views/mc-appointment-details-body-notes.php",
        {apmt_id: apmt_id} ,
        function (responseText) {
            $("#ngc-mc-appmt-div-note").html(responseText); 
            $("#ngc-mc-tbl-apmt-note tr").click(function () {
                var id=$(this).closest('tr').attr('id');
                if($('#ngc-mc-appmt-selected-note-id').val()==id){
                    //Deselect
                    console.log($('#ngc-mc-appmt-selected-note-id').val()+"-"+id);
                    $('#ngc-mc-appmt-selected-note-id').val('');
                    $(this).removeClass('mi-selected');
                }
                else{
                    $('#ngc-mc-appmt-selected-note-id').val(id);
                    $("#ngc-mc-tbl-apmt-note tr").removeClass('mi-selected');
                    $(this).addClass('mi-selected');
                }
            });
        }
    );
            
}

function clearSelected(view){
    if(view=='2'){
        $(".mi-calendar-main-content-block").find('.mi-calender-main-sub-block-1-inner-content').removeClass('ui-selected');
        $("."+ps_selected_date).find('.mi-calender-main-sub-block-1-inner-content').removeClass('ng-calender-avail');
        $('#ngs-ps-save').removeClass('ngs_span_but_disable').addClass('ngs_span_but_enable');
    }
}
function saveSchedule(unit_id,doc_id,user_id){
    console.log("called save");
    console.log(unit_id+" "+doc_id+" "+user_id);
    console.log(ps_selected_slots);
    
    var ary_date_digit=ps_selected_date.split('');
    var d=ary_date_digit[0]+ary_date_digit[1]+ary_date_digit[2]+ary_date_digit[3]+"-"+ary_date_digit[4]+ary_date_digit[5]+"-"+ary_date_digit[6]+ary_date_digit[7];
    
    console.log('Date:'+d);
    $.post("models/ajx/ajxc_mc_provider_schedule_2.php?option=add",
        {unit_id:unit_id, doctor_id: doc_id, user_id: user_id,selected_date:ps_selected_date, slots:ps_selected_slots},
        function(json) {
            console.log(json);
            if(json[0]['result']=='1'){
                closeMiModel(2,'mi-propagate-schedule');
                alert("Schedule updated");
                $('#ngs-ps-save').removeClass('ngs_span_but_enable').addClass('ngs_span_but_disable');
                $('.ui-selected').toggleClass('ui-selected');
                fillAvailability(unit_id,doc_id,d,false,2)
            } 
            else{
                alert("Error :"+json[1]['error']);
            }
    },'json');
}
function openStatusChange(id){
    console.log('status change');
    $('#ngc-modle-dialog-header').html('Change Status');
    $.post("views/mc-appointment-status-change.php?",
        {user_id: $('#ng-mc-home-user_id').val(),apmt_id:id} ,
        function (responseText) {
            $("#ngc-modle-dialog-content").html(responseText);
            //$('#ngc-mc-loading').addClass("mi-hide");                    
            openMiModel(2,'ngc-modle-dialog');
        }
    );
}
function moveAppointment(apmt_id,ts){
    $('#ngc-mc-loading').removeClass("mi-hide");
    $.post("models/ajx/ajxc_mc_appointment.php",{option:"slot-change",apmt_id: apmt_id, start_ts:ts}, function(json) {
      console.log(json);
      $('#ngc-mc-loading').addClass("mi-hide");
        if(json[0]['result']=='1'){          
        }
        else{
            alert("Error :"+json[1]['error']);
        }
    },'json');
}
function resizeAppointment(apmt_id,start_h,end_h){
    $('#ngc-mc-loading').removeClass("mi-hide");
    $.post("models/ajx/ajxc_mc_appointment.php",{option:"slot-resize",apmt_id: apmt_id, start_h:start_h, end_h: end_h}, function(json) {
      console.log(json);
      $('#ngc-mc-loading').addClass("mi-hide");
        if(json[0]['result']=='1'){          
        }
        else{
            alert("Error :"+json[1]['error']);
        }
    },'json');
}
function setAppointmentStatus(apmt_id,s){
    $('#ngc-mc-loading').removeClass("mi-hide");
    $.post("models/ajx/ajxc_mc_appointment.php",{option:"status-change",apmt_id: apmt_id, status:s}, function(json) {
      console.log(json);
      if(json[0]['result']=='1'){
          $('#ngc-mc-loading').addClass("mi-hide");
          closeMiModel(2,'ngc-modle-dialog');
          removeAppointment(apmt_id);
          loadAppointment(apmt_id);
    }
    else{
        alert("Error :"+json[1]['error']);
    }
    },'json');
}
function completeAppointment(apmt_id){
    $('#ngc-mc-loading').removeClass("mi-hide");
    $.post("models/ajx/ajxc_mc_appointment.php",{option:"status-change",apmt_id: apmt_id, status:'COMPLETE'}, function(json) {
      console.log(json);
      if(json[0]['result']=='1'){
          $('#ngc-mc-loading').addClass("mi-hide");
          closeMiModel(2,'ngc-modle-dialog');
          removeAppointment(apmt_id);
          loadAppointment(apmt_id);
          $("#mi-appointment-model").addClass('mi-hide');    
    }
    else{
        alert("Error :"+json[1]['error']);
    }
    },'json');
}
function uncompleteAppointment(apmt_id){
    $('#ngc-mc-loading').removeClass("mi-hide");
    $.post("models/ajx/ajxc_mc_appointment.php",{option:"status-change",apmt_id: apmt_id, status:'UNCOMPLETE'}, function(json) {
      console.log(json);
      if(json[0]['result']=='1'){
          $('#ngc-mc-loading').addClass("mi-hide");
          closeMiModel(2,'ngc-modle-dialog');
          removeAppointment(apmt_id);
          loadAppointment(apmt_id);
          $("#mi-appointment-model").addClass('mi-hide');    
    }
    else{
        alert("Error :"+json[1]['error']);
    }
    },'json');
}

function scanAndUploadDirectly(ptn_id,type,user_id) {
   scanner.scan(displayServerResponse,
       {
           "output_settings": [
               {
                   "type": "upload",
                   "format": "pdf",
                   "upload_target": {
                       "url": "127.0.0.1/HIS/models/ajx/ajxc_mc_patient.php?option=c-note-file-upload",
                       "post_fields": {
                           "ptn_id": ptn_id,
                           "type":type,
                           "user_id":user_id
                       },
                       "cookies": document.cookie,
                       "headers": [
                           "Referer: " + window.location.href,
                           "User-Agent: " + navigator.userAgent
                       ]
                   }
               }
           ]
       }
   );
}

function displayServerResponse(successful, mesg, response) {
   if(!successful) { // On error
       document.getElementById('server_response').innerHTML = 'Failed: ' + mesg;
       return;
   }
   if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
       document.getElementById('server_response').innerHTML = 'User cancelled';
       return;
   }
   var json_response = JSON.parse(scanner.getUploadResponse(response));
   console.log(json_response);
   if(json_response[0].result==1){
        document.getElementById('server_response').innerHTML = 'success';        
   }
   else{
       document.getElementById('server_response').innerHTML = 'failed';
   }
}
function initializeClinicalNoteScan(ptn_id,user_id){
    var newDiv = $(document.createElement('div')); 
    $(newDiv).html('<table width="100%" border="0" class="ngsvtable"></tr><tr><td width="30%">Type:</td><td><select name="note_type" id="note_type"><option value="G">General</option><option value="C">Clinical</option></select></td></tr></table>');
    $(newDiv).attr('title','Select Note Type');
    $(newDiv).css('font-size','70%');
    $(newDiv).css('z-index','110');
    $(newDiv).dialog({
        resizable: false,
        height:200,
        modal: true,
        buttons: {
          "Scan": function() {
                var type=$("#note_type").val();	
                scanAndUploadDirectly(ptn_id,type,user_id);
                loadPatinerClinicalNotes(ptn_id);
                $( this ).dialog( "close" );
                
          },
          Close: function() {
            $( this ).dialog( "close" );
          }
        }
      });
  }

