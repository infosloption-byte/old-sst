
//These codes takes from http://t4t5.github.io/sweetalert/
function showBasicMessage(title) {
    swal(title);
}

function showWithTitleMessage(title,message) {
    swal(title,message);
}

function showSuccessMessage(title,message) {
    swal(title,message,"success");
}


function showConfirmMessage(title,message,confirmtext,type,func) {
    swal({
        title: title,
        text: message,
        type: type,
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: confirmtext,
        closeOnConfirm: false
    },func);
}

function showCancelMessage(title,message,type,func) {
    swal({
        title: title,
        text: message,
        type: type,
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
    }, func);
}

function showWithCustomIconMessage(title,message,url) {
    swal({
        title: title,
        text: message,
        imageUrl: url
    });
}

function showHtmlMessage(title,message) {
    swal({
        title: title,
        text: message,
        html: true
    });
}

function showAutoCloseTimerMessage(title,message,time) {
    swal({
        title: title,
        text: message,
        timer: time,
        showConfirmButton: false
    });
}

function showPromptMessage(title,message,func) {
    swal({
        title: title,
        text: message,
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Write something"
    },func);
}

function showAjaxLoaderMessage(title,message,func) {
    swal({
        title: title,
        text: message,
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, func);
}