    
    var timeout = 600000; // 10 minutes idle time
    // var timeout = 300000; // 5 minutes idle time
    // var timeout = 3000; // 3 seconds idle time

    var logoutTimer = setTimeout(function() 
    { 


        // window.location.href = "logout.php";

Swal.fire({
  title: 'Session timeout. Please log in to continue.',
  text: "Press yes to continue!",
  icon: 'warning',
  showCancelButton: false,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => 
{
  if (result.isConfirmed) 
  {

    window.location.href = "logout.php";

  }

}) 


}, timeout);




    // Reset the timer on user activity
    document.addEventListener("mousemove", resetTimer);
    document.addEventListener("keypress", resetTimer);

    function resetTimer() 
    {
        clearTimeout(logoutTimer);
        logoutTimer = setTimeout(function() 
        {
            // window.location.href = "logout.php";

Swal.fire({
  title: 'Session timeout. Please log in to continue.',
  text: "Press yes to continue!",
  icon: 'warning',
  showCancelButton: false,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => 
{
  if (result.isConfirmed) 
  {

    window.location.href = "logout.php";

  }

}) }, timeout);

// window.location.href = "logout.php";

    }














    