{include file='admin/header.tpl'}
{* T935 CFS Dashboard File Created *}
<script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}prototype.js"></script>
<link href="{$ADMIN_CSS_PATH}jquery-ui.css" rel="stylesheet">
<link href="{$ADMIN_CSS_PATH}jquery.multiselect_new.css" rel="stylesheet">
<script src="{$ADMIN_JS_PATH}jquery-1.12.4.js"></script>
<script src="{$ADMIN_JS_PATH}jquery-ui.js"></script>
<script src="{$ADMIN_JS_PATH}jquery.multiselect_new.js"></script>

{literal}

<style type="text/css">
    div{margin:0; padding:0;}
    .boxcont{
        width:250px;
        float:left;
        padding:5px 7px; 
        border:1px solid #cecece;
        font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
        color:#999;
    }
    .ms-options-wrap{
        position:relative !important;
    }
    .ms-options-wrap.ms-active{
         position:relative !important;
    }
    .boxcont a{
        width:250px;
        float:left;
        padding:5px 7px;
        border:1px solid #cecece;
        font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
        color:#999;
    }
    #company_type{
        cursor:pointer;
    }
    .company_type_option{
        padding: 5px !important;
        margin: 5px !important;

    }

    .bcontainer
    {
        width:820px;
        margin:0 auto;
        background-color:#eee;
        border-left:#000000 solid 1px;
        border-right:#000000 solid 1px;

        border-bottom:#000000 solid 1px;
        padding:15px;
    }
    select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: none;
    text-align:center;
    }
    .label a{
        float: left;
        width: 250px;
        font-weight: 900;
        margin-right:15px;
        font-size:18px;
    }
    select{
    border: 1px solid #000;
    border-radius:0px;
    text-indent: 42px;
    }
    option{
    text-indent: 42px;

    }
    .label h2
    {
        font:bold 18px Arial, Helvetica, sans-serif;
        margin-top:5px;
        color: #261908;
    }
    input{
        border-radius:0px;
    }
    input, textarea{
        width:250px;
        float:left;
        padding:5px 7px;
        border:1px solid #000;
        color:#000;
        font-weight:900;
    }
    textarea{
        width: 250px;
        height: 150px;
        padding:5px 10px;
    }
    table th {
        /* color: #fff !important; */
    }
    table th, table td {
        border: 2px solid #000;
        padding:5px 10px 9px;
    }
{{* Changes *}}
label{
    padding-top: 6px;
    font-size: 13px;
    line-height: 18px;
    float: left;
    width: 130px;
    font-weight: 600;
    text-align: left;
    color: #404040;
    font-weight: 900;

}
.financial_year{
    text-align: center;
    width: 25%;
    color:#000;
    background-color: #fff;
    font-weight:bold;
}
.ms-options-wrap button{
    text-align: center;
    width: 25% !important;
    color:#000;
    background-color: #fff;
    font-weight:bold;
}
li {
    line-height: 3px !important;
    color: #fff !important;
}
.ms-options-wrap > .ms-options {
    position: absolute;
    left: 21% !important;
    width: 25% !important;
    margin-top: 1px;
    margin-bottom: 20px;
    background: white;
    z-index: 2000;
    border: 1px solid #aaa;
    text-align: left;
    min-height: 50px !important;
    overflow: hidden !important;
    max-height: 155px !important;
}
.ms-options-wrap > button:after {
    content: unset !important;
    height: 0;
    position: absolute;
    top: 50%;
    right: 5px;
    width: 0;
    border: 6px solid rgba(0, 0, 0, 0);
    border-top-color: #999;
    margin-top: -3px;
}
.ms-options-wrap > button:focus, .ms-options-wrap > button {
    position: relative;
    width: 100%;
    text-align: center !important;
    border: 1px solid #020202 !important;
    background-color: #fff;
    padding: 5px 20px 5px 5px;
    margin-top: 1px;
    font-size: 13px;
    color: #0b0711 !important;
    outline: none;
    overflow: hidden !important;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.ms-options-wrap > .ms-options > ul input[type="checkbox"] {
    margin-right: 5px;
    position: absolute;
    left: 4px;
    top: 2px !important;
}
.ms-options-wrap > .ms-options > ul label {
    position: relative;
    display: inline-block;
    width: 100%;
    padding: 4px 4px 0px 20.8px !important;
    margin: 1px 0;
}
.company_type{
    border-radius: 0px;
    width: 25%;
    text-align: center;
    background-color: #fff;
    height:28px;
    color:#000;
    font-weight:bold;
}


::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #909;
    font-size:12px;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #909;
   font-size:12px;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    #909;
   font-size:12px;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    #909;
   font-size:12px;
}
#refine{
    cursor:pointer;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.ms-selectall.global{
    width: 86%;
    font-size: 14px !important;
    font-weight: 400;
    text-transform: capitalize !important;
    color: black;
    text-align: center;
    margin: 5px !important;
}
.ms-options-wrap > .ms-options > ul input[type="checkbox"] {
    margin-right: 5px;
    position: absolute;
    left: 4px;
    margin-top: 5px !important;
    top: 2px !important;
}
</style>
<script>
$(document).ready(function(){
    $('#financial_year').val(['16', '17', '18', '19', '20']);
    $("#financial_year").multiselect("refresh");

    $('#financial_year').multiselect({
        texts: {
      placeholder    :'Select All',// text to use in dummy input
      selectedOptions:' selected',     // selected suffix text
      selectAll      :'Select all',    // select all text
      unselectAll    :'Unselect all',  // unselect all text
      noneSelected   :'None Selected'   // None selected text
      },
      onLoad: function (element, option) {
        $('.ms-has-selections button span').html('Select All');
        },
        
        columns: 1,
        placeholder: 'Select All',
        search: false,
        selectAll: true,
        selectAllText: "Select All"
    });
  $("#refine_form").on('submit', function(e){
      $FY_length = $("#financial_year :selected").length;
      if($FY_length == 0){
          alert('Please select Financial Year');
          return false;
      }
    $('.ajax-loader').show();
    // $('.bcontainer').css('opacity', '0.5');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "cfsdashboard/cfsdashboard_ajax.php",
            data: new FormData(this),
            contentType: false,
            dataType: "json",
            cache: false,
            processData:false,
            success: function(response){
                console.log(response);
                if(response != 'please check revenue values'){
                    $('#xbrl_PEBacked').empty();
                    $('#xbrl_nonPEBacked').empty();
                    $('#xbrl_pebacked_nonpebacked_total').empty();
                    $('#nonxbrl_PEBacked').empty();
                    $('#nonxbrl_nonPEBacked').empty();
                    $('#nonxbrl_pebacked_nonpebacked_total').empty();
                    $('#xbrl_nonxbrl_pebacked_total').empty();
                    $('#xbrl_nonxbrl_nonpebacked_total').empty();
                    $('#total').empty();

                    $('#xbrl_PEBacked').html(response.xbrl_PEBacked_count);
                    $('#xbrl_nonPEBacked').html(response.xbrl_nonPEBacked_count);
                    $('#xbrl_pebacked_nonpebacked_total').html(response.xbrl_pebacked_nonpebacked_total);
                    $('#nonxbrl_PEBacked').html(response.nonxbrl_PEBacked_count);
                    $('#nonxbrl_nonPEBacked').html(response.nonxbrl_nonPEBacked_count);
                    $('#nonxbrl_pebacked_nonpebacked_total').html(response.nonxbrl_pebacked_nonpebacked_total);
                    $('#xbrl_nonxbrl_pebacked_total').html(response.xbrl_nonxbrl_pebacked_total);
                    $('#xbrl_nonxbrl_nonpebacked_total').html(response.xbrl_nonxbrl_nonpebacked_total);
                    $('#first').html(response.firstinarr);
                    $('#second').html(response.secinarr);
                    $('#total').html(response.total);
                    $('.ajax-loader').hide();
                }else{
                    $('.ajax-loader').hide();
                    alert('please check revenue values');
                }
            },
            error : function(data){
                  $('.ajax-loader').hide();
                  alert('please check revenue values');
            }
        });
        return false;
    });
});
function revenueAction() {
  $FY_length = $("#financial_year :selected").length;
}

 // apply the two-digits behaviour to elements with 'two-digits' as their class
 $( function() {
 $('#revenue_min').keyup(function(){
   if($(this).val().indexOf('.')!=-1){         
       if($(this).val().split(".")[1].length > 2){                
           if( isNaN( parseFloat( this.value ) ) ) return;
           this.value = parseFloat(this.value).toFixed(2);
       }  
    }            
    return this; //for chaining
 });
});
 // apply the two-digits behaviour to elements with 'two-digits' as their class
 $( function() {
 $('#revenue_max').keyup(function(){
   if($(this).val().indexOf('.')!=-1){         
       if($(this).val().split(".")[1].length > 2){                
           if( isNaN( parseFloat( this.value ) ) ) return;
           this.value = parseFloat(this.value).toFixed(2);
       }  
    }            
    return this; //for chaining
 });
});

</script>
{/literal}
</head>
<body>
<div class="ajax-loader" style="z-index: 99999;position: fixed;width: 100%;height: 100%;overflow: hidden;background: rgb(255, 255, 255);opacity: 0.75;display: none;">
    <div style="position:absolute; left:50%; top:50%; margin:-250px 0 0 -250px;">
        <img src="../images/loading_page1.gif" width="508" height="381" alt=""> 
    </div>
</div>
<div class="bcontainer">
    <div class="label" style="margin-bottom:10px;">
        <h2>Dashboard</h2>
    </div>
    
    <div style="clear:both"></div>
    <div style="width:100%">
    <form id="refine_form" method="post" name="refine_form" autocomplete="off">
        <div style="width: 20%;float: left;">
            <div style="padding:5px;margin:10px;">
                <b style="font-size:18px;font-weight: 900;">Filters</b>
            </div>
        </div>
        <div style="width: 75%;float: left;padding: 5px;margin: 10px;">
            <div style="width:100%;margin: 0px 0px 15px 0px;">
                <div >
                    <label>Company Type : </label> 
                    <select id="company_type" name="company_type" class="company_type">
                        <option value="-" class="company_type_option">  Select All</option>
                        <option value="1" class="company_type_option">  Listed Cos</option>
                        <option value="2" class="company_type_option">  Pvt Ltd</option>
                        <option value="3" class="company_type_option"> Partnership</option>
                        <option value="4" class="company_type_option"> Proprietorship</option>
                    </select>
                </div>
            </div>
            <div style="width:100%;margin: 0px 0px 15px 0px;">
                <div >
                    <label>Financial Year : </label> 
                    <select id="financial_year" class="financial_year" name="financial_year[]" multiple="multiple" onchange="revenueAction()">
                        <option value="20">FY20</option>
                        <option value="19">FY19</option>
                        <option value="18">FY18</option>
                        <option value="17">FY17</option>
                        <option value="16">FY16</option>
                    </select>
                </div>
            </div>
            <div style="width:100%;margin: 0px 0px 15px 0px;">
                <div >
                    <label>Revenue (INR Cr): </label> 
                    <div style="float:left;">
                        <label style="font-size: 11px;font-weight: normal;width:65px;">  Greater than </label>
                        <input type="number" name="revenue_min" id="revenue_min" step="any" style="width:60px;height:15px;margin-right: 10px;" value="0" />
                    </div>
                    <label style="font-size: 11px;font-weight: normal;width:52px">less than </label>
                    <input type="number" name="revenue_max" id="revenue_max" step="any" style="width:60px;height:15px;margin-right: 10px;"/>
                
               
                </div>
            <br />
            </div>
            <div style="margin: 5px;padding: 5px;margin-left: 20%;margin-top: 26px;">
                <button type="submit" style="font-weight: 900;border: 2px solid;padding: 4px 20px 2px 20px;" id="refine">REFINE</button>
            </div>
        </div>
        </form>
    </div>
    <div style="clear:both"></div>
    <div style="width:100%">
        <div style="width: 20%;float: left;">
            <div style="padding:5px;margin:10px;">
                <b style="font-size:18px;font-weight: 900;">Summary</b>
            </div>
        </div>
        <div style="width: 75%;float: left;padding: 5px;margin: 10px;">
            <div style="width:100%;margin: 0px 0px 15px 0px;">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="font-weight:900">Category</th>
                        <th style="font-weight:900"><center>PE Backed</center></th>
                        <th style="font-weight:900"><center>Non PE Backed</center></th>
                        <th style="font-weight:900"><center>Total</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="padding-left: 20px;">XBRL</td>
                        <td id="xbrl_PEBacked">{$cfsdashboard.xbrl_PEBacked_count}</td>
                        <td id="xbrl_nonPEBacked">{$cfsdashboard.xbrl_nonPEBacked_count}</td>
                        <td id="xbrl_pebacked_nonpebacked_total">{$cfsdashboard.xbrl_pebacked_nonpebacked_total}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 20px;">Non XBRL</td>
                        <td id="nonxbrl_PEBacked">{$cfsdashboard.nonxbrl_PEBacked_count}</td>
                        <td id="nonxbrl_nonPEBacked">{$cfsdashboard.nonxbrl_nonPEBacked_count}</td>
                        <td id="nonxbrl_pebacked_nonpebacked_total">{$cfsdashboard.nonxbrl_pebacked_nonpebacked_total}</td>
                    </tr>
                    <tr>
                        <td><b>Total</b></td>
                        <td id="xbrl_nonxbrl_pebacked_total">{$cfsdashboard.xbrl_nonxbrl_pebacked_total}</td>
                        <td id="xbrl_nonxbrl_nonpebacked_total">{$cfsdashboard.xbrl_nonxbrl_nonpebacked_total}</td>
                        <td id="total">{$cfsdashboard.total}</td>
                    </tr>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>
	<div style="clear:both"></div>
    <div style="width:100%">
        <div style="width: 20%;float: left;">
            <div style="padding:5px;">
                <b style="font-size:18px;font-weight: 900;">Industrywise</b>
            </div>
        </div>
        <div style="width: 75%;float: left;padding: 5px;margin: 10px;">
            <div style="width:100%;margin: 0px 0px 15px 0px;">
                <div style="width:49%;float:left">
            
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="font-weight: 900;">Industry <span style="float:right;font-weight:normal">No of Cos</span></th>
                        </tr>
                        </thead>
                        <tbody id="first">
                        {section name=List loop=$industries1}
                        <tr> <td>  {$industries1[List].iname}  
                        <span style="float:right"> {$industries1[List].comcount} </span>
                        </td></tr>
                        
                        {/section}
                        </tbody>
                    </table>  
                </div>
                <div style="width:49%;float:right">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="font-weight: 900;">Industry
                            <span style="float:right;font-weight:normal">No of Cos</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody id="second">
                         {section name=List loop=$industries2}
                        <tr> <td>  {$industries2[List].iname} 
                        <span style="float:right"> {$industries2[List].comcount} </span>
                        
                        </td></tr>
                        {/section}
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>
    </div>
    <div style="clear:both;">&nbsp;</div>
    <div style="clear:both"></div>
</div>
</body>
</html>