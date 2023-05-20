// Toggle class active

const navbarNav = document.querySelector(".navbar-nav");
// ketika humbeger menu di klik
document.querySelector("#hamburger-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

// Klik di luar sidebar untuk menghilangkan nav
const hamburger = document.querySelector("#hamburger-menu");

document.addEventListener("click", function (e) {
  if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});

// Code to convert select to UL
$('.select').each(function () {
  var $select = $(this).find('select'),
    $list = $('<ul />');
  $select.find('option').each(function () {
    $list.append('<li>' + $(this).text() + '</li>');
  });
  //Remove the select after the values are taken
  $select.after($list).remove();


  //Append Default text to show the selected
  $(this).append('<span>select</span>')
  var firsttxt = $(this).find('li:first-child').text();
  $(this).find('span').text(firsttxt)

  // On click show the UL
  $(this).on('click', 'span', function (e) {
    e.stopPropagation();
    $(this).parent().find('ul').show();
  });

  // On select of list select the item
  $(this).on('click', 'li', function () {
    var gettext = $(this).text();
    $(this).parents('.select').find('span').text(gettext);
    $(this).parent().fadeOut();
  });

})


// On click out hide the UL
$(document).on('click', function () {
  $('.select ul').fadeOut();
});

// pop up logout
function logoutConfirmation() {
  Swal.fire({
    title: 'keluar?',
    text: "Apakah Anda yakin?",
    icon: 'question',
    showCancelButton: true,
    cancelButtonColor: '#3085d6',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#d33',
    confirmButtonText: 'Keluar',
    focusCancel: true,
    background: '#ffcf9c'
  }).then((result) => {
    if (result.isConfirmed) {
      var baseUrl = window.location.origin;
      var routeUrl = baseUrl + '/logout'
      document.location.href = routeUrl;
    }
  })
}