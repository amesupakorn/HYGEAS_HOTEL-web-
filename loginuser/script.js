const notifications = document.querySelector(".notifications"),
buttons = document.querySelectorAll(".submit");

const toastDetails = {
    timer: 5000,
    success: {
        icon: 'fa-circle-check',
        text: 'Success: This is a success toast.',
    },
    error: {
        icon: 'fa-circle-xmark',
        text: 'Error: This is an error toast.',
    },
    warning: {
        icon: 'fa-triangle-exclamation',
        text: 'Warning: This is a warning toast.',
    },
    info: {
        icon: 'fa-circle-info',
        text: 'Info: This is an information toast.',
    }
}

const removeToast = (toast) => {
    toast.classList.add("hide");
    if(toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
    setTimeout(() => toast.remove(), 500); // Removing the toast after 500ms
}

const createToast = (id) => {
    // Getting the icon and text for the toast based on the id passed
    const { icon, text } = toastDetails[id];
    const toast = document.createElement("li"); // Creating a new 'li' element for the toast
    toast.className = `toast ${id}`; // Setting the classes for the toast
    // Setting the inner HTML for the toast
    toast.innerHTML = `<div class="column">
                         <i class="fa-solid ${icon}"></i>
                         <span>${text}</span>
                      </div>
                      <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>`;
    notifications.appendChild(toast); // Append the toast to the notification ul
    // Setting a timeout to remove the toast after the specified duration
    toast.timeoutId = setTimeout(() => removeToast(toast), toastDetails.timer);
}

// Adding a click event listener to each button to create a toast when clicked
buttons.forEach(btn => {
    btn.addEventListener("click", () => createToast(btn.id));
});




// check

src="https://code.jquery.com/jquery-3.7.1.min.js";
integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=";
crossorigin="anonymous";

var firstnameError = document.getElementById('error-firstname');
var lastnameError = document.getElementById('error-lastname');
var EmailError = document.getElementById('error-email');
var phoneError = document.getElementById('error-phone');
var userError = document.getElementById('error-user');
var passError = document.getElementById('error-pass');
var conpassError = document.getElementById('error-conpass');
var SubmitError = document.getElementById('error-submit');




function validatefirst(){
    var name = document.getElementById('contact-firstname').value;

    if(name.length == 0){
        firstnameError.innerHTML = 'Name is required';
        return false;
    }

    firstnameError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;
}

function validatelast(){
    var name = document.getElementById('contact-lastname').value;

    if(name.length == 0){
        lastnameError.innerHTML = 'Name is required';
        return false;
    }

    lastnameError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;
}

function validatephone(){

    var phone = document.getElementById('contact-phone').value;

    if(phone.length == 0){
        phoneError.innerHTML = 'Phone no is required';
        return false;
    }
    if(phone.length != 10){
        phoneError.innerHTML = 'Phone no should be 10 digits';
        return false;
    }

    if(!phone.match(/^[0-9]{10}$/)){
        phoneError.innerHTML = 'Phone no is required';
        return false;
    }

    phoneError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true

}

function validateemail(){

    var email = document.getElementById('contact-email').value;

    if(email.length == 0){
        EmailError.innerHTML = 'Email is required';
        return false;
    }
    if(!email.match(/^[A-Za-z\._\-[0-9]*[@][A-Za-z]*[\.][a-z]{2,4}$/)){
        EmailError.innerHTML = 'Email Invalid';
        return false;
    }

    EmailError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;


}

function validateuserfail(){

    userError.innerHTML = 'Username is already in use';
    return false;
}


function validateuser(){
    var user = document.getElementById('contact-user').value;
    
    if(user.length == 0){
        userError.innerHTML = 'Username is required';
        return false;
    }

    userError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;
    // var Data = new FormData();

    // Data.append('username', user);
    // $.ajax({
    //     url: 'register.php',
    //     type: 'POST',
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     data: Data,
    //     success: function(res){
    //         console.log(res);
    //     }
    // });

}

function validatepass(){

    var pass = document.getElementById('contact-pass').value;

    if(pass.length < 4){
        passError.innerHTML = 'Password is required';
        return false;
    }

    passError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;


}

function validateconpass(){

    var pass = document.getElementById('contact-pass').value;
    var conpass = document.getElementById('contact-cpass').value;

    if(pass != conpass){
        conpassError.innerHTML = 'not match with Password';
        return false;
    }
    conpassError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;


}

