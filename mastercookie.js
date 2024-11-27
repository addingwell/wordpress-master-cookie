document.addEventListener("DOMContentLoaded", function() {
    if (!document.cookie.includes("_aw_master_id")) {
        fetch(dynamic_cookie_data.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'set_dynamic_master_cookie'
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Cookie _aw_master_id successfully set"); // Optional: Log success message
                }
            })
            .catch(error => console.error("Error setting the cookie _aw_master_id"));
    }
});
