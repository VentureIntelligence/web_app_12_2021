<style>
#testpopup{
    display:none;
    position: fixed;
    left: 0;
    top:0;
    background: #000;
    z-index: 8000;
    overflow: hidden;
    width: 100%;
    height: 100%;
    opacity: 0.7;
  }
  /* @media and (max-width: 600px) {
    #testpopup{
      display:block ;    
     
  } */
}
</style>
<div id="testpopup" style=""></div>
<div class="lb" id="popup-box-copyrights" >
<span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
<div class="copyright-body" style="text-align: center;font-size: 12px !important;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
</div>
<div class="cr_entry" style="text-align:center;">
    
    <input type="button" value="I Agree" id="agreebtn" />
</div>

</div>
<script type="text/javascript">
		var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
		var element = document.getElementById('text');
		if (isMobile) {
            document.getElementById("testpopup").style.display = "block";
		} else {
            document.getElementById("testpopup").style.display = "none";
		}
	</script>