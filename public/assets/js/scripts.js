(function(window, undefined) {
  'use strict';

  /*
  NOTE:
  ------
  PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
  WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */
  
  
  // Notificaiton init
  if (!("Notification" in window)) {
      alert("This browser does not support desktop notification");
  }else{
    Notification.requestPermission().then(function(result) {
      console.log(result);
    });
  }
})(window);