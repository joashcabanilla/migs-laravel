$(document).ready(() => {
    for (let key in intervalId) {
        clearInterval(intervalId[key]);
    }

    intervalId.dashboard = setInterval(() => {
        location.reload();
    }, 3000);
    
});