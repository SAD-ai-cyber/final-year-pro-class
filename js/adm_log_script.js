// Helper function.
function showForm(formId){
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}


window.onload = function() {
        if(window.history.replaceState){
            window.history.replaceState(null, null, window.location.href);
        }
    }
    
    // Agar user Back button dabata hai, to page ko Force Reload karo
    // Taki PHP session check dobara chale
    window.onpageshow = function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    };
