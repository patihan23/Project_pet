	$(function(){
		$.datetimepicker.setLocale('th');
	    var optsDate = {  
	        format:'Y-m-d', // รูปแบบวันที่ 
	        formatDate:'Y-m-d',
	        timepicker:false,   
	        closeOnDateSelect:true,
	    } 
	    var optsTime = {
	        format:'H:i', // รูปแบบเวลา
	        step:30,  // step เวลาของนาที แสดงค่าทุก 30 นาที 
	        formatTime:'H:i',
	        datepicker:false,
	    }    
	    var setDateFunc = function(ct,obj){
	        var minDateSet = $("#startDate").val();
	        var maxDateSet = $("#endDate").val();
	         
	        if($(obj).attr("id")=="startDate"){
	            this.setOptions({
	                //minDate:false, //กำหนดเลือกวันที่ย้อนหลังได้
	                minDate: 0, //กำหนดเลือกวันที่ย้อนหลังไม่ได้
	                maxDate:maxDateSet?maxDateSet:false 
	            })                   
	        }
	        if($(obj).attr("id")=="endDate"){
	            this.setOptions({
	                maxDate:false,
	                minDate:minDateSet?minDateSet:false
	            })                   
	        }
	    }
	     
	    var setTimeFunc = function(ct,obj){
	        var minDateSet = $("#startDate").val();
	        var maxDateSet = $("#endDate").val();        
	        var minTimeSet = $("#startTime").val();
	        var maxTimeSet = $("#endTime").val();
	         
	        if(minDateSet!=maxDateSet){
	            minTimeSet = false;
	            maxTimeSet = false;
	        }
	         
	        if($(obj).attr("id")=="startTime"){
	            this.setOptions({
	                defaultDate:minDateSet?minDateSet:false,
	                minTime:false,
	                maxTime:maxTimeSet?maxTimeSet:false        
	            })                   
	        }
	        if($(obj).attr("id")=="endTime"){
	            this.setOptions({
	                defaultDate:maxDateSet?maxDateSet:false,
	                minTime:minTimeSet?minTimeSet:false      
	            })                   
	        }
	    }    
	     
	    $("#startDate,#endDate").datetimepicker($.extend(optsDate,{  
	        onShow:setDateFunc,
	        onSelectDate:setDateFunc,
	        minDate: 0,
	    }));
	     
	    $("#startTime,#endTime").datetimepicker($.extend(optsTime,{  
	        onShow:setTimeFunc,
	        onSelectTime:setTimeFunc,
	    }));       
	});
