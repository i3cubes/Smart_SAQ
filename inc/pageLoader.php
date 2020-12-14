<style>
    #page-loader.fade.in {
    display: block;
}
#page-loader {
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: #E6E8EC;
    z-index: 9999;
    position: fixed;
}
.fade.in {
    opacity: 1;
}
.fade {
    transition: opacity .3s linear;
}

.spinner_page {
  border-radius: 50%;
  border-top: 5px solid #3498db;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 40px;
  height: 40px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 1s linear infinite;
} 

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.hide{
    display: none;
}
</style> 
<div id="page-loader" class="fade in"><span class="spinner_page"></span></div>