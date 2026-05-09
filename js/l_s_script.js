const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login2-btn');


registerBtn.addEventListener('click', () =>{
    container.classList.add('active');
});
    
loginBtn.addEventListener('click', () =>{
    container.classList.remove('active');
});
    
window.onload = function() {
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    }

    window.onpageshow = function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    };
