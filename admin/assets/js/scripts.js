document.addEventListener('DOMContentLoaded', function() {
    function updateClock() {
        const now = new Date();
        const clockOptions = {
           hour: 'numeric',
           minute: 'numeric',
           second: 'numeric',
           hour12: true,
           timeZone: 'Asia/Kolkata', // GMT+5:30
        };
        const dateOptions = {
           weekday: 'short', // Abbreviate weekday (e.g., Mon)
           year: 'numeric',
           month: 'short', // Abbreviate month (e.g., Jan)
           day: 'numeric',
        };

        // Update clock
        const timeString = now.toLocaleTimeString('en-US', clockOptions);
        document.getElementById('clock').textContent = timeString;

        // Update date and day
        const dateString = now.toLocaleDateString('en-US', dateOptions);
        document.getElementById('dateAndDay').textContent = dateString;
    }

    // Update the clock and date every second
    setInterval(updateClock, 1000);
});

 
 function confirmExternalLink(event) {
      event.preventDefault(); // Prevent the default link behavior

      // Show confirmation dialog
      if (confirm("This will redirect you to an external link. Do you want to proceed?")) {
          // Open the link in a new tab
          window.open(event.currentTarget.href, '_blank');
      }
      // If user cancels, do nothing
  }


  document.addEventListener('DOMContentLoaded', function() {
   document.querySelector('#logoutButton').addEventListener('click', function (event) {
     event.preventDefault();
 
     fetch('paths/logout.php', {
       method: 'POST',
     })
     .then(response => {
       if (!response.ok) {
         throw new Error('Network response was not ok');
       }
       return response.json();
     })
     .then(data => {
       if (data.status === 'success') {
         $('#logout_modal').modal('show');
         setTimeout(function () {
           location.reload();
         }, 2000);
       } else {
         console.error('Logout unsuccessful');
       }
     })
     .catch(error => console.error('Error:', error));
   });
 });