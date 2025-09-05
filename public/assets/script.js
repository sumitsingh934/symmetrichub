function showPopup() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;
    //const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const education = document.getElementById('education').value;
    const experience = document.getElementById('experience').value;

    if (
        username === "" ||
        password === "" ||
        role === "" ||
       // email === "" ||
        phone === "" ||
        education === "" ||
        experience === ""
    ) {
        alert("Please fill all required fields.");
        return;
    }

    document.getElementById('popup').style.display = 'flex';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';

    // Optional: Clear form fields after closing
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
    document.getElementById('role').value = '';
   // document.getElementById('email').value = '';
    document.getElementById('phone').value = '';
    document.getElementById('education').value = '';
    document.getElementById('experience').value = '';
    document.getElementById('linkedin').value = '';
}
// ✅ Register Function
function registerUser() {
    const username = document.getElementById('reg-username').value.trim();
    //const email = document.getElementById('reg-email').value.trim();
    const phone = document.getElementById('reg-phone').value.trim();
    const password = document.getElementById('reg-password').value;
    const confirmPassword = document.getElementById('reg-confirm-password').value;

    if (!username || !email || !phone || !password || !confirmPassword) {
        alert("Please fill all fields.");
        return;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return;
    }

    let users = JSON.parse(localStorage.getItem("users")) || [];

    const existingUser = users.find(u => u.email === email);
    if (existingUser) {
        alert("User with this email already exists.");
        return;
    }

    users.push({ username, email, phone, password });

    localStorage.setItem("users", JSON.stringify(users));
    alert("Registration successful! You can now sign in.");
    window.location.href = 'signin.html';
}

// ✅ Sign In Function
function signInUser() {
    const email = document.getElementById('signin-email').value.trim();
    const password = document.getElementById('signin-password').value;

    if (!email || !password) {
        alert("Please enter both email and password.");
        return;
    }

    let users = JSON.parse(localStorage.getItem("users")) || [];

    const user = users.find(u => u.email === email && u.password === password);

    if (user) {
        localStorage.setItem("currentUser", JSON.stringify(user));
        alert(`Welcome ${user.username}!`);
        window.location.href = 'dashboard.html';
    } else {
        alert("Incorrect email or password.");
    }
}

// ✅ Logout Function (Optional)
function logoutUser() {
    localStorage.removeItem("currentUser");
    window.location.href = 'signin.html';
}

// ✅ Dashboard Check Function
function checkAuth() {
    const user = JSON.parse(localStorage.getItem("currentUser"));
    if (!user) {
        alert("Please sign in first.");
        window.location.href = 'signin.html';
    }
}
// ✅ Save login status on successful sign in
function signIn() {
    // Assuming validation success
    localStorage.setItem('isLoggedIn', 'true');
    window.location.href = 'dashboard.html';
}

// ✅ Check login status on dashboard
window.onload = function() {
    const loggedIn = localStorage.getItem('isLoggedIn');
    if (!loggedIn) {
        // alert('Please log in first.');
        // window.location.href = 'signin.html';
    }
}

// ✅ Logout function
function logout() {
    localStorage.removeItem('isLoggedIn');
    window.location.href = 'signin.html';
}
