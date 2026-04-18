function getdata(data){
    return data;
}


// Store key/value in a persistent browser cookie (72 hours)
function setit(key, value) {
    Cookies.set(key, value, { expires: 3, sameSite: 'Lax' }); // 3 days = 72 hours
}

// Read a cookie value; returns "" if not set
function getit(key) {
    var val = Cookies.get(key);
    return (val === undefined) ? "" : val;
}

// Remove a cookie (try both with and without options to catch cookies set either way)
function removeit(key) {
    Cookies.remove(key, { sameSite: 'Lax' });
    Cookies.remove(key); // also remove any legacy cookie set without options
}

// Remove all known auth cookies
function clearit() {
    Cookies.remove('signinUser', { sameSite: 'Lax' });
}
